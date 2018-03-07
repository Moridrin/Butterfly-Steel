(define (create-floorplan-start-image grid-image base-image edges-layer export-name)
    (let* (
            ; first main image
            (image (car (gimp-file-load RUN-NONINTERACTIVE grid-image grid-image)))
            ; them layer
            (image-drawable (car (gimp-image-get-active-drawable image)))
            ; open image as layer
            (base-drawable (car (gimp-file-load-layer RUN-NONINTERACTIVE image base-image)))
            ; open image as layer
            (edges-drawable (car (gimp-file-load-layer RUN-NONINTERACTIVE image edges-layer)))
            ; get image format
            (width (car (gimp-drawable-width image-drawable)))
            (height (car (gimp-drawable-height image-drawable)))
            ; create walls layer
            (walls-layer (car (gimp-layer-new image width height 1 "Walls" 100 0)))
            ; create water layer
            (water-layer (car (gimp-layer-new image width height 1 "Water" 100 0)))
            ; create grass layer
            (grass-layer (car (gimp-layer-new image width height 1 "Grass" 100 0)))
            ; create hills layer
            (hills-layer (car (gimp-layer-new image width height 1 "Hills" 100 0)))
            ; create mountains layer
            (mountains-layer (car (gimp-layer-new image width height 1 "Mountains" 100 0)))
            ; create roads layer
            (roads-layer (car (gimp-layer-new image width height 1 "Roads" 100 0)))
            ; create forrest layer
            (forrest-layer (car (gimp-layer-new image width height 1 "Forrest" 100 0)))
        )

        ; add Walls layer
        (gimp-image-add-layer image walls-layer -1)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add water layer
        (gimp-context-set-pattern "Water2")
        (gimp-image-add-layer image water-layer -1)
        (gimp-drawable-fill water-layer 4)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add grass layer
        (gimp-context-set-pattern "Grass2")
        (gimp-image-add-layer image grass-layer -1)
        (gimp-drawable-fill grass-layer 4)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add hills layer
        (gimp-context-set-pattern "Hills2")
        (gimp-image-add-layer image hills-layer -1)
        (gimp-drawable-fill hills-layer 4)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add mountains layer
        (gimp-context-set-pattern "Mountain")
        (gimp-image-add-layer image mountains-layer -1)
        (gimp-drawable-fill mountains-layer 4)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add Roads layer
        (gimp-image-add-layer image roads-layer -1)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add forrest layer
        (gimp-context-set-pattern "Forrest")
        (gimp-image-add-layer image forrest-layer -1)
        (gimp-drawable-fill forrest-layer 4)
        (gimp-rect-select image 0 0 width height 2 FALSE 0)

        ; add layer to image
        (gimp-image-insert-layer image base-drawable 0 0)

        ; add layer to image
        (gimp-image-insert-layer image edges-drawable 0 0)

        ; save
        (gimp-xcf-save RUN-NONINTERACTIVE image image-drawable export-name export-name)
    )
)