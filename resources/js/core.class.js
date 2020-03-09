
class CoreClass {
    addToQuery(addKey, addVal) {
        let key, val, exists;
        let queryArr = (window.query.length > 0) ? window.query.split('&') : [];

        for(let i = 0; i < queryArr.length; i++) {
            [key, val] = queryArr[i].split('=');

            if (key === addKey) {
                queryArr[i] = addKey+'='+addVal;
                return queryArr.join('&');
            }
        }

        queryArr.push(addKey+'='+addVal);

        return queryArr.join('&');
    }

    ajaxGet(url, data, callback, loader) {
        if(typeof data === 'function') {
            loader = callback;
            callback = data;
            data = '';
        }

        if (loader !== false) {
            $('#loader').show();
        }

        $.get(url, data).done((res) => {
            if (loader !== false) {
                $('#loader').hide();
            }

            callback( (res[0] === '{') ? JSON.parse(res) : res );
        });
    }

    ajaxPost(url, type, data, callback, loader) {
        if(typeof data === 'function') {
            loader = callback;
            callback = data;
            data = '';
        }

        if (loader !== false) {
            $('#loader').show();
        }

        $.ajax({
            type: type,
            url: url,
            data: data,
            success: function (res) {
                if (loader !== false) {
                    $('#loader').hide();
                }

                callback( (res[0] === '{') ? JSON.parse(res) : res );
            },
            dataType: 'html'
        });
    }

    // ajaxForm(callback) {
    //     $.ajax({
    //         data: $(this).serialize(),
    //         type: $(this).attr('method'),
    //         url: $(this).attr('action'),
    //         success: function(response) {
    //             callback(response);
    //         }
    //     });
    //     return false;
    // }

    getCookie(name) {
        let cookieName = `${name}=`;
        let cookieArray = document.cookie.split(';');

        for (let cookie of cookieArray) {
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }

            if (cookie.indexOf(cookieName) === 0) {
                return cookie.substring(cookieName.length, cookie.length);
            }
        }
    }

    setCookie(name, value, expires) {
        let dateStr = '';

        if (expires) {
            const date = new Date();
            date.setTime(date.getTime() + (expires*24*60*60*1000));
            dateStr = `; expires=" ${date.toUTCString()}`;
        }
        document.cookie = `${name}=${value || ''}${dateStr}; path=/`;
    }

    clearCookie(name) {
        this.setCookie(name, null, -1);
    }
}

// export
export default (new CoreClass);
