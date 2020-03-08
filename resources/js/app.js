
import "./../sass/app.scss";

//require('./bootstrap');
require('./cart');
require('./common');
require('./compare');
require('./shop');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
