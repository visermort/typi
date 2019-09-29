(function(){
    $('.multiinput').each(function(index, element) {
        var data = $(element).data('value');
        var attribute = $(element).data('attribute');

        function copyValues(item, parent) {
            for(var prop in item) {
                if (typeof item[prop] == 'object') {
                    copyValues(item[prop], parent+'['+prop+']');
                } else {
                    var name = parent+'['+prop+']';
                    $(element).find('input[name="'+name+'"]').val(item[prop]);
                    $(element).find('textarea[name="'+name+'"]').html(item[prop]);
                }
            }
        }
        copyValues(data, attribute);
    });

    $('body').on('click', '.multiinput-elem-add', function(){
        var tbody = $(this).closest('.multiinput').find('table tbody');
        var rows = $(tbody).find('tr');
        if (rows.length) {
            var newRow = $(rows[0]).clone();
            console.log(newRow);
            tbody.append(newRow);
            clearRowValues(newRow);
            orderRowNumbers(tbody)

        }
    });

    $('body').on('click', '.multiinput-elem-remove', function() {
        var tbody = $(this).closest('tbody');
        if ($(tbody).find('tr').length > 1) {
            $(this).closest('tr').remove();
            orderRowNumbers(tbody);
        }
    });

    function orderRowNumbers(tbody) {
        var rows = $(tbody).find('tr');
        var attribute = $(tbody).closest('.multiinput').data('attribute');
        console.log(attribute);
        $(rows).each(function(index, row) {
            var inputs = $(row).find('input,select,textarea');
            $(inputs).each(function(i, input) {
                var name = $(input).attr('name');
                var pattern = '^'+attribute+'\\[\\d+\\]';
                var replacement = attribute+'['+index+']';
                var newName = name.replace(new RegExp(pattern), replacement);
                $(input).attr('name', newName);
                $(input).attr('id', newName);
                $(input).siblings('label').attr('for', newName);
            });
        });
    }
    function clearRowValues(row)
    {
        $(row).find('input').val('');
        $(row).find('textarea').html('');
    }

})();