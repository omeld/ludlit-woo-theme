window.addEventListener("DOMContentLoaded", function () {
    const colorThief = new ColorThief();
    let my_dominant_color = '';
    let my_color_palette = [];
    const ludlit_wc_author_images = document.querySelectorAll(
        ".ludlit_wc_product_image_wrapper.ludlit_wc_has_main_author_img img"
        //".ludlit_wc_product_image_wrapper img"
    );
    
    function ludlit_wc_set_gradient(element, color_start, color_end = 'var(--ludlit-wc-product-background-color)') {
        element.parentNode.style.background = 'radial-gradient('
            + 'circle, '
            + 'rgba(' + color_start.join(',') + ',0.5' + ')' 
            + ' 0%, ' 
            + 'rgba(' + color_end.join(',') + ',0.5' + ')' 
            + ' 90%'
            + ')';
    }

    // Make sure image is finished loading
    ludlit_wc_author_images.forEach(function(img) {
        if (img.complete) {
            my_dominant_color = colorThief.getColor(img);
            my_color_palette = colorThief.getPalette(img, 2);
            ludlit_wc_set_gradient(img, my_color_palette[0], my_color_palette[1]);
        } else {
            img.addEventListener('load', function() {
                my_dominant_color = colorThief.getColor(img);
                my_color_palette = colorThief.getPalette(img, 2);
                ludlit_wc_set_gradient(img, my_color_palette[0], my_color_palette[1]);
            });
        }
    });

});

