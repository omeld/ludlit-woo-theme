window.addEventListener("DOMContentLoaded", function () {
    const colorThief = new ColorThief();
    //let my_dominant_color = '';
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

    /* make this async!
    // Make sure image is finished loading
    ludlit_wc_author_images.forEach(function(img) {
        if (img.complete) {
            my_dominant_color = colorThief.getColor(img, 20);
            my_color_palette = colorThief.getPalette(img, 2, 20);
            ludlit_wc_set_gradient(img, my_color_palette[0], my_color_palette[1]);
        } else {
            img.addEventListener('load', function() {
                my_dominant_color = colorThief.getColor(img, 20);
                my_color_palette = colorThief.getPalette(img, 2, 20);
                ludlit_wc_set_gradient(img, my_color_palette[0], my_color_palette[1]);
            });
        }
    });
    */
    async function ludlit_wc_get_colors(img) {
        return new Promise((resolve, reject) => {
            if (img.complete) {
                resolve({
                    //color: colorThief.getColor(img, 20),
                    palette: colorThief.getPalette(img, 2, 10)
                });
            } else {
                img.addEventListener('load', function() {
                    resolve({
                        //color: colorThief.getColor(img, 20),
                        palette: colorThief.getPalette(img, 2, 10)
                    });
                });
            }
        }).then(result => {
            console.log('ludlit gradients:', result.palette);
            return result;
        });
    }

    async function ludlit_wc_prepare_gradient(img) {
        //const {color, palette} = await ludlit_wc_get_colors(img);
        const { palette } = await ludlit_wc_get_colors(img);
        ludlit_wc_set_gradient(img, palette[0], palette[1]);
    }

    //apply to all
    ludlit_wc_author_images.forEach(function(img) {
        ludlit_wc_prepare_gradient(img)
            .catch(error => console.error('ludlitwc gradients:', error));
    });

});


//todo: try this code
/*
window.onload = function() {
    const ludlit_wc_author_images = document.querySelectorAll(
      ".ludlit_wc_product_image_wrapper.ludlit_wc_has_main_author_img img"
    );
    
    async function setGradientAsync(img) {
      const colorThief = new ColorThief();
      try {
        const colorPalette = await getPaletteAsync(colorThief, img, 2, 20);
        ludlit_wc_set_gradient(img, colorPalette[0], colorPalette[1]);
      } catch (error) {
        console.error('Error setting gradient:', error);
      }
    }
  
    ludlit_wc_author_images.forEach(function(img) {
      setGradientAsync(img);
    });
  };
  */