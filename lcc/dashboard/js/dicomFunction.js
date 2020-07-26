    element.addEventListener('cornerstoneimagerendered', onImageRendered);
    // Add event handler to the ww/wc apply button
        document.getElementById('x256').addEventListener('click', function (e) {
            element.style.width = '256px';
            element.style.height = '256px';
            cornerstone.resize(element);
        });

        document.getElementById('x512').addEventListener('click', function (e) {
            element.style.width = '512px';
            element.style.height = '512px';
            cornerstone.resize(element);
        });

        document.getElementById('invert').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.invert = !viewport.invert;
            cornerstone.setViewport(element, viewport);
        });

        // document.getElementById('interpolation').addEventListener('click', function (e) {
        //     const viewport = cornerstone.getViewport(element);
        //     viewport.pixelReplication = !viewport.pixelReplication;
        //     cornerstone.setViewport(element, viewport);
        // });
        document.getElementById('hflip').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.hflip = !viewport.hflip;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('vflip').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.vflip = !viewport.vflip;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('rotate').addEventListener('click', function (e) {
            const viewport = cornerstone.getViewport(element);
            viewport.rotation += 90;
            cornerstone.setViewport(element, viewport);
        });
        document.getElementById('lengthFunc').addEventListener('click', function (e) {
            const LengthTool = cornerstoneTools.LengthTool;
            cornerstoneTools.addTool(LengthTool)
            cornerstoneTools.setToolActive('Length', { mouseButtonMask: 1 })
        });
        document.getElementById('markerFunc').addEventListener('click', function (e) {
            const TextMarkerTool = cornerstoneTools.TextMarkerTool
            const configuration = {
              markers: ['F5', 'F4', 'F3', 'F2', 'F1'],
              current: 'F5',
              ascending: true,
              loop: true,
            }
            cornerstoneTools.addTool(TextMarkerTool, { configuration })
            cornerstoneTools.setToolActive('TextMarker', { mouseButtonMask: 1 })
        });
        document.getElementById('magnifyFunc').addEventListener('click', function (e) {
            const MagnifyTool = cornerstoneTools.MagnifyTool;

            cornerstoneTools.addTool(MagnifyTool)
            cornerstoneTools.setToolActive('Magnify', { mouseButtonMask: 1 })
        });

        document.getElementById('wwwcFunc').addEventListener('click', function (e) {
            const WwwcTool = cornerstoneTools.WwwcTool;
            cornerstoneTools.addTool(WwwcTool)
            cornerstoneTools.setToolActive('Wwwc', { mouseButtonMask: 1 })
        });
        document.getElementById('rotateFunc').addEventListener('click', function (e) {
            const RotateTool = cornerstoneTools.RotateTool;
            cornerstoneTools.addTool(RotateTool)
            cornerstoneTools.setToolActive('Rotate', { mouseButtonMask: 1 })
        });
        document.getElementById('zoomFunc').addEventListener('click', function (e) {
            const ZoomTool = cornerstoneTools.ZoomTool;

            cornerstoneTools.addTool(cornerstoneTools.ZoomTool, {
              // Optional configuration
              configuration: {
                invert: false,
                preventZoomOutsideImage: false,
                minScale: .1,
                maxScale: 20.0,
              }
            });
            cornerstoneTools.setToolActive('Zoom', { mouseButtonMask: 1 })
        });
        document.getElementById('angleFunc').addEventListener('click', function (e) {
            const AngleTool = cornerstoneTools.AngleTool;
            cornerstoneTools.addTool(AngleTool)
            cornerstoneTools.setToolActive('Angle', { mouseButtonMask: 1 })
        });

        element.addEventListener('mousemove', function(event) {
            const pixelCoords = cornerstone.pageToPixel(element, event.pageX, event.pageY);
            document.getElementById('coord1s').textContent = "PageX= " + event.pageX;
            document.getElementById('coord2s').textContent = "PageY= " + event.pageY;
            document.getElementById('coord3s').textContent = "PixelX= " + pixelCoords.x;
            document.getElementById('coord4s').textContent = "PixelY= " + pixelCoords.y;
        });