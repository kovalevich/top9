function getItem (id, type, type1){
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/getitem/'+type,
        data: {
            id: id,
            type: type1
        },
        beforeSend: function(){
            $('#social').html('идет загрузка...');
        },
        success: function(data){
            $('#social').html(data);
        }
    });
}