const map_type = data_js.map_type;
const map_dynamic_3d = data_js.map_dynamic_3d;
const map_dynamic_preset = data_js.map_dynamic_preset;
const map_color = data_js.map_color;
const hex_color = map_color != '' ? map_color : accent_color;

function animateBars(sectionElement) {
    const animationSpeed = parseInt(sectionElement.dataset.speed, 10);

    const bars = sectionElement.querySelectorAll(".pwe-map__stats-diagram-bar-item");
    bars.forEach(bar => {
        const percentage = parseFloat(bar.getAttribute("data-count"));
        const targetHeight = percentage + "%"; // Procentowy target

        bar.style.height = "0";
        const numberElement = bar.querySelector(".pwe-map__stats-diagram-bar-number");

        let currentHeight = 0;
        const frameRate = 15;
        const totalFrames = animationSpeed / frameRate;
        const heightIncrement = percentage / totalFrames;

        const interval = setInterval(() => {
            currentHeight += heightIncrement;

            if (currentHeight >= percentage) {
                currentHeight = percentage;
                clearInterval(interval);
            }
            bar.style.height = currentHeight + "%";
        }, frameRate);
    });
}


function animateCount(element) {
    const targetValue = parseInt(element.getAttribute("data-count"), 10);
    const duration = 3000; 

    const startTime = performance.now();
    const update = (currentTime) => {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1); 
        const currentValue = Math.floor(progress * targetValue);

        element.textContent = currentValue;

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    };
    requestAnimationFrame(update);
}


document.addEventListener("DOMContentLoaded", () => {
    const countUpElements = document.querySelectorAll(".countup");
    const barSections = document.querySelectorAll(".pwe-map__stats-diagram-bars");

    // Unified observer for visibility-triggered animations
    const observer = new IntersectionObserver(
        (entries, observerInstance) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;

                    if (target.classList.contains("countup")) {
                        animateCount(target);
                    } else if (target.classList.contains("pwe-map__stats-diagram-bars") && !target.dataset.animated) {
                        animateBars(target);
                        target.dataset.animated = true;
                    }

                    // Stop observing once animated
                    observerInstance.unobserve(target); 
                }
            });
        },
        {
            // Trigger when 10% visible
            threshold: 0.1 
        }
    );

    // Add observers to elements
    countUpElements.forEach(element => observer.observe(element));
    barSections.forEach((section, index) => {
        // Set specific scaling and speed parameters
        const sectionParams = [
            { scaleFactor: "300", speed: "2000" },
            { scaleFactor: "4", speed: "1500" },
            { scaleFactor: "300", speed: "2500" }
        ];
        const params = sectionParams[index] || sectionParams[0]; // Default to the first set
        section.dataset.scaleFactor = params.scaleFactor;
        section.dataset.speed = params.speed;

        observer.observe(section);
    });
});


if (map_type === 'PWEMap3D' || map_dynamic_3d || map_dynamic_preset === 'preset_2') {

    // Initialize scene, camera and renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, 1 / 1, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({
        alpha: true,
        antialias: true,
        precision: "highp"
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    document.getElementById("container-3d").appendChild(renderer.domElement);

    renderer.domElement.addEventListener("webglcontextlost", (event) => {
        console.warn("WebGL context lost");
        event.preventDefault(); // Zapobiega domyślnemu zachowaniu
    });

    renderer.domElement.addEventListener("webglcontextrestored", () => {
        console.log("WebGL context restored");
        // Konieczne może być ponowne załadowanie modelu i sceny
        initScene();
    });

    // Add light to scene
    const ambientLight = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 10, 7.5).normalize();
    scene.add(directionalLight);

    // Loading the GLTF model using GLTFLoader
    const loader = new THREE.GLTFLoader();
    loader.load("/wp-content/plugins/PWElements/media/mapa.gltf", function(gltf) {
        const model = gltf.scene;

        // Create group as pivot
        const pivot = new THREE.Group();

        // Usuń poprzedni model (jeśli istnieje)
        if (scene.children.includes(pivot)) {
            pivot.traverse((node) => {
                if (node.isMesh) {
                    node.geometry.dispose();
                    if (node.material.map) node.material.map.dispose();
                    node.material.dispose();
                }
            });
            scene.remove(pivot);
        }

        pivot.add(model);

        // Set model scaling to 3.5, 3.5, 3.5
        model.scale.set(3.5, 3.5, 3.5);

        // Change model color to blue while preserving materials
        model.traverse((node) => {
            if (node.isMesh) {
                // Preserve shadow settings and change color at the same time
                node.material = new THREE.MeshStandardMaterial({
                    color: hex_color,   // Kolor modelu
                    metalness: node.material.metalness,  // Preserving metallicity
                    roughness: node.material.roughness,  // Preserving roughness
                    emissive: node.material.emissive,  // Emission behavior
                    opacity: node.material.opacity,    // Preserving transparency
                    transparent: node.material.transparent // Preserving transparency
                });

                // Shadow behavior
                node.castShadow = true;
                node.receiveShadow = true;
            }
        });

        // Center the model in the pivot group
        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());
        model.position.set(-center.x, -center.y, -center.z);

        // Additional correction to the model position to align it with the bottom
        // model.position.y -= 0.2;  // Przesuwamy model nieco w dół, by zmniejszyć przestrzeń u dołu

        // Adding a pivot to the scene
        scene.add(pivot);

        // Animation function
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }

        // Rotate the pivot around the Y axis while scrolling
        // window.addEventListener("scroll", () => {
        //     const rotationAmount = window.scrollY * 0.001;
        //     pivot.rotation.y = rotationAmount;
        // });

        // Camera initialization
        camera.position.z = 11; // Zwiększenie wartości z (oddalenie kamery od modelu)

        // Optionally, we increase the FOV (camera viewing angle)
        camera.fov = 40;
        camera.updateProjectionMatrix();

        // Animation function (auto rotate)
        let autoRotate = true; // Flag to enable/disable auto rotation
        let rotationSpeed = 0.006; // Rotation speed
        let lastFrameTime = 0;
        const targetFPS = 30; // Limited to 30 frames per second
        const frameDuration = 1000 / targetFPS;

        function animate(time) {
            if (time - lastFrameTime >= frameDuration) {
                lastFrameTime = time;

                // Obrót modelu
                if (autoRotate) {
                    model.rotation.y += rotationSpeed;
                }

                renderer.render(scene, camera);
            }
            requestAnimationFrame(animate);
        }

        // Start animation
        animate(0);

    }, undefined, function(error) {
        console.error("An error happened while loading the model:", error);
    });

    // Update camera aspect ratio when window resizes
    window.addEventListener("resize", () => {
        const container = document.getElementById("container-3d");
        const width = container.clientWidth;
        const height = container.clientHeight;

        // We update the camera aspect ratio based on the container size
        camera.aspect = width / height;
        camera.updateProjectionMatrix();

        // We set the renderer size based on the container dimensions
        renderer.setSize(width, height);
    });
}