if (typeof Toastify !== 'undefined') {
    (() => {
        const defaultOptions = {
            duration: 5 * 1000,
            escapeMarkup: false,
            //destination: "https://github.com/apvarun/toastify-js",
            //newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: false, // Prevents dismissing of toast on hover
            style: {
                width: '300px'
            }
            //onClick: function(){} // Callback after click
        };

        window.toastify = {
            success(title = null, msg = null, extraOptions = {}) {
                if (msg && typeof msg === 'object') {
                    extraOptions = msg;
                    msg = null;
                }

                extraOptions.style = {
                    background: extraOptions.backgroundColor = 'linear-gradient(to right, rgb(0, 176, 155), rgb(150, 201, 61))'
                }

                handleToast(title, msg, extraOptions)
            },
            info(title = null, msg = null, extraOptions = {}) {
                if (msg && typeof msg === 'object') {
                    extraOptions = msg;
                    msg = null;
                }

                extraOptions.style = {
                    background: extraOptions.backgroundColor = 'linear-gradient(to right, rgb(0 62 175), rgb(88 155 255))'
                }

                handleToast(title, msg, extraOptions)
            },
            warning(title = null, msg = null, extraOptions = {}) {
                if (msg && typeof msg === 'object') {
                    extraOptions = msg;
                    msg = null;
                }

                extraOptions.style = {
                    background: extraOptions.backgroundColor = 'linear-gradient(to right, rgb(255, 95, 109), rgb(255, 195, 113))'
                }

                handleToast(title, msg, extraOptions)
            },
            error(title = null, msg = null, extraOptions = {}) {
                if (msg && typeof msg === 'object') {
                    extraOptions = msg;
                    msg = null;
                }

                extraOptions.style = {
                    background: extraOptions.backgroundColor = 'linear-gradient(to right, rgb(175 0 0), rgb(255 88 88))'
                }

                handleToast(title, msg, extraOptions)
            },
        };

        function handleToast(title, msg, extraOptions) {
            extraOptions.text = getTextLayout(title, msg);

            Toastify(merge(defaultOptions, extraOptions)).showToast();
        }

        function getTextLayout(title, msg) {
            if (title !== null && msg !== null) {
                return `<div><b>${title}</b><br><p>${msg}</p></div>`;
            } else {
                return title;
            }
        }

        function merge(old_obj, new_obj) {
            const obj = _.mergeWith({}, old_obj, new_obj);

            if (new_obj.hasOwnProperty('size')) {
                // available: lg

                if (new_obj['size'] === 'lg') {
                    obj.style.width = '450px'
                }
            }

            return obj;
        }
    })()
}
