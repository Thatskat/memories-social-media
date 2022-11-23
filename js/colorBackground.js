var granimInstance = new Granim({
    element: '#canvas-basic',
    direction: 'top-bottom',
    isPausedWhenNotInView: true,
    image : {
        source: './img/background-img/cloud-background.jpg',
        blendingMode: 'multiply',
    },
    states : {
        "default-state": {
            gradients: [
                ['#06b6d4', '#0891b2'],
                ['#0e7490', '#155e75'],
                ['#0284c7', '#0369a1'],
                ['#075985', '#0c4a6e']
            ],
            transitionSpeed: 7000
        }
    }
});