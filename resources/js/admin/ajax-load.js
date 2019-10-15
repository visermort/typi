var ajaxLoad = (function(){

    $('body').on('click', '.load-modal', function(e){
        e.preventDefault();
        var that = $(this);
        var href = that.attr('href');
        var modal = $('#load-modal');
        if (!href || !modal) {
            return;
        }
        that.addClass('loading');
        axios
            .get(href, null)
            .then(response => {
                console.log(response);
                if (response) {
                    if (response.data.title) {
                         modal.find('.modal-title').html(response.data.title);
                    }
                    if (response.data.content) {
                        modal.find('.modal-body').html(response.data.content);
                    }
                }
                modal.modal();
            })
            .catch(error => {
                console.log('error',error);
            });
    });


})();