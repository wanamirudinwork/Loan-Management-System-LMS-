scriptTags = document.getElementsByTagName('script');
jsPath = scriptTags[scriptTags.length - 1].src.split('?')[0].split('/').slice(0, -1).join('/') + '/';
rootPath = jsPath.split('assets');
rootPath.pop();
rootPath = rootPath.join('assets');
sitePath = rootPath.split('backpanel');
sitePath.pop();
sitePath = sitePath.join('backpanel');

url = document.URL.split('/');
thelast = url[url.length - 1] ? url[url.length - 1] : url[url.length - 2];
backUrl = url[url.length - 1] ? document.URL.replace(/\/[^\/]*$/, '') : document.URL.replace(/\/[^\/]*$/ + '/', '');

$(function() {

    $('html').bind('ajaxStart', function() {
        $(this).addClass('busy');
    }).bind('ajaxStop', function() {
        $(this).removeClass('busy');
    });

    $(window).resize(function() {
        winWidth = $(window).width();
        winHeight = $(window).height();

        if (winWidth <= 975) sortableDisable();
        else sortable();

    }).resize();

    if ($('.datatable').length) $('.datatable').dataTable({ "aaSorting": [], "pageLength": 25 });
    if ($('.chosen-select').length) $('.chosen-select').chosen();
    if ($('.colorpicker').length) $('.colorpicker').colorpicker();

    if ($('.date').length) {
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    }

    $('#loginform').submit(function() {
        $.ajax({
            type: 'POST',
            url: './login',
            dataType: 'json',
            data: $('#loginform').serialize(),
            success: function(results) {
                if (results.error == true) {
                    t('e', results.msg);
                } else {
                    t('s', results.msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(error) {
                ajax_error(error);
            },
            complete: function() {}
        });
        return false;
    });

    $("#statusForm").submit(function() {
        var data = $(this).serializeArray();
        if ($(this).find('#html').length == 1) data.push({ name: 'content', value: CKEDITOR.instances.html.getData() });
        if ($(this).find('#description').length == 1) data.push({ name: 'description', value: CKEDITOR.instances.description.getData() });
        if ($(this).find('#description2').length == 1) data.push({ name: 'description2', value: CKEDITOR.instances.description2.getData() });
        // ajax_form(data);
        ajax_form_delivery(data);
        return false;
    });

    $("#selfForm").submit(function() {
        var data = $(this).serializeArray();
        if ($(this).find('#html').length == 1) data.push({ name: 'content', value: CKEDITOR.instances.html.getData() });
        if ($(this).find('#description').length == 1) data.push({ name: 'description', value: CKEDITOR.instances.description.getData() });
        if ($(this).find('#description2').length == 1) data.push({ name: 'description2', value: CKEDITOR.instances.description2.getData() });
        // ajax_form(data);
        ajax_form_action(data, '', '');
        return false;
    });

    $("#backForm").submit(function() {
        var data = $(this).serializeArray();
        if ($(this).find('#html').length == 1) data.push({ name: 'content', value: CKEDITOR.instances.html.getData() });
        if ($(this).find('#description').length == 1) data.push({ name: 'description', value: CKEDITOR.instances.description.getData() });
        if ($(this).find('#description2').length == 1) data.push({ name: 'description2', value: CKEDITOR.instances.description2.getData() });
        ajax_form_action(data, '', 'direct');
        return false;
    });

    $('.delete').live('click', function(e) {
        e.preventDefault();

        row = $(this).closest('tr');
        id = $(this).data('id');
        type = $(this).data('type');
        var data = { act: 'delete', type: type, id: id }

        bootbox.confirm('<i class="fa fa-warning danger"></i> <strong>Are you sure to delete this ' + type + '?</strong>', function(result) {
            if (result === true) {
                ajax_form(data, rootPath + 'delete', '.datatable');

                row.fadeOut(function() {
                    row.remove();
                });
            }
        });
    });

    $('.delete-borrower-list').live('click', function(e) {
        e.preventDefault();

        row = $(this).closest('tr');
        bid = $(this).data('bid');
        url = $(this).data('url');
        action = $(this).data('action');
        var data = {}

        bootbox.confirm('<i class="fa fa-warning danger"></i> <strong>Are you sure to delete?</strong>', function(result) {
            if (result === true) {
                ajax_form(data, rootPath + url + '/' + bid + '/' + action, '.datatable');

                row.fadeOut(function() {
                    row.remove();
                });
            }
        });
    });

    $('.delete-borrower').live('click', function(e) {
        e.preventDefault();

        row = $(this).closest('tr');
        bid = $(this).data('bid');
        id = $(this).data('id');
        column = $(this).data('column');
        url = $(this).data('url');
        action = $(this).data('action');

        let data = {}

        bootbox.confirm('<i class="fa fa-warning danger"></i> <strong>Are you sure to delete - <span style="text-transform: uppercase">' + column + '?<span></strong>', function(result) {
            if (result === true) {
                ajax_form(data, rootPath + url + '/' + bid + '/' + action + '/' + id, '.datatable');
                row.fadeOut(function() {
                    row.remove();
                });
            }
        });
    });


    $('.back').live('click', function(e) {
        e.preventDefault();
        window.location = backUrl;
    });

    if (window.location.hash) {
        var hash = window.location.hash.substring(1);
        $('a[href="#' + hash + '"]').click();
    }

    $('.country').live('change', function() {
        id = $(this).val();
        el = $(this);

        $.ajax({
            type: 'GET',
            url: rootPath + 'country/' + id,
            dataType: 'json',
            data: {},
            success: function(results) {
                if (results.error == true) {
                    t('e', results.msg);
                } else {
                    el.parent().parent().next().find('select.state').html(results.states);
                    $('.selectpicker').selectpicker('refresh')
                }
            },
            error: function(error) {
                ajax_error(error);
            },
            complete: function() {

            }
        });
    });

    $('.addMultiImg a').live('click', function() {
        newTotal = $('.multiImg').length + 1;
        while ($('#photo' + newTotal).length != 0) {
            newTotal++;
        }
        newImg = '<div class="multiImg">';
        newImg += '<input id="photo' + newTotal + '" name="images[' + newTotal + '][src]" value="" type="hidden">';
        newImg += '<input name="images[' + newTotal + '][alt]" class="form-control" placeholder="LABEL" value="" type="text">';
        newImg += '<a href="javascript:void(0)" onclick="kcFinderB(\'photo' + newTotal + '\')">Browse</a> | ';
        newImg += '<a href="javascript:void(0)" onclick="kcFinderR(\'photo' + newTotal + '\')">Cancel</a>';
        newImg += '</div>';
        $(this).parent().prev().append(newImg);
    });

    if (!$('.multiImg').length) $('.addMultiImg a').click();

    $('.addMultiPrices a').live('click', function() {
        newTotal = $('.multiImg').length;
        while ($('select[name="prices[' + newTotal + '][country]"]').length != 0) {
            newTotal++;
        }
        newImg = '<div class="multiPrices">';
        newImg += '<select class="form-control" name="prices[' + newTotal + '][country]">' + countryList + '</select> ';
        newImg += '<input type="text" class="form-control" name="prices[' + newTotal + '][price]" placeholder="Price" value=""> ';
        newImg += '<a href="#" title="Remove"><i class="fa fa-trash-o"></i></a>';
        newImg += '</div>';
        $(this).parent().prev().append(newImg);
    });

    $('.multiPrices a, .multiOptions > a, ul.options > li > a, ul.option > li > a').live('click', function(e) {
        e.preventDefault();
        el = $(this);
        el.parent().remove();
    });

    $('.addMultiOptions a').live('click', function() {
        newTotal = $('.multiOptions').length;
        while ($('input[name="options[' + newTotal + '][title]"]').length != 0) {
            newTotal++;
        }
        option = '<div class="multiOptions" data-id="' + newTotal + '">';
        option += '<input type="text" class="form-control" name="options[' + newTotal + '][title]" placeholder="Title (Eg: Size)" value="" required> ';
        option += '<a href="#" title="Remove"><i class="fa fa-trash-o"></i></a> ';
        option += '<ul class="options">';
        option += '<a href="javascript:;" class="btn btn-default"><i class="fa fa-plus"></i> Add Value</a>';
        option += '</ul>';
        option += '</div>';
        $(this).parent().prev().append(option);
    });

    $('ul.options > a').live('click', function(e) {
        e.preventDefault();
        id = $(this).closest('.multiOptions').data('id');

        newTotal = $(this).parent().find('li').length;
        while ($('input[name="options[' + id + '][values][' + newTotal + '][title]"]').length != 0) {
            newTotal++;
        }

        li = '<li>';
        li += '<input type="text" class="form-control" name="options[' + id + '][values][' + newTotal + '][title]" value="" placeholder="Title" required> ';
        li += '<input type="text" class="form-control" name="options[' + id + '][values][' + newTotal + '][price]" value="" placeholder="Price (Eg: +10 or -10)"> ';
        li += '<input type="text" class="form-control" name="options[' + id + '][values][' + newTotal + '][stock]" value="0" placeholder="Stock"> ';
        li += '<a href="#" title="Remove"><i class="fa fa-trash-o"></i></a>';
        li += '</li>';

        $(this).before(li);
    });

    $('ul.option > a').live('click', function(e) {
        e.preventDefault();
        id = $(this).closest('.singleOption').data('id');

        newTotal = $(this).parent().find('li').length;
        while ($('input[name="colors[' + newTotal + '][title]"]').length != 0) {
            newTotal++;
        }

        li = '<li>';
        li += '<input type="text" class="form-control" name="colors[' + newTotal + '][title]" value="" placeholder="Title" required> ';
        li += '<input type="text" class="form-control colorpicker" name="colors[' + newTotal + '][code]" value="" placeholder="#000000" required> ';
        li += '<input type="text" class="form-control" name="colors[' + newTotal + '][price]" value="" placeholder="Price (Eg: +10 or -10)"> ';
        li += '<input type="text" class="form-control" name="colors[' + newTotal + '][stock]" value="0" placeholder="Stock"> ';
        li += '<a href="#" title="Remove"><i class="fa fa-trash-o"></i></a>';
        li += '</li>';

        $(this).before(li);
        $('.colorpicker').colorpicker();
    });

    sortable();

    $('.remove-slider').live('click', function(e) {
        e.preventDefault();
        el = $(this).parent();
        el.slideUp(function() {
            el.remove();
        });
    });

    $('.add-more-slider').live('click', function(e) {
        e.preventDefault();

        newTotal = $('.multi-slider li').length;
        while ($('input[name="slide[' + newTotal + '][src]"]').length != 0) {
            newTotal++;
        }
        el = '<li>';
        el += '<input id="photo' + newTotal + '" type="text" class="form-control" onclick="kcFinderB(\'photo' + newTotal + '\')" name="slide[' + newTotal + '][src]" value="" placeholder="Browse" required>';
        el += '<input type="text" class="form-control" name="slide[' + newTotal + '][href]" value="" placeholder="http://www.google.com/">';
        el += '<input type="button" class="btn btn-danger btn-sm remove-slider" value="Remove">';
        el += '</li>';
        $('ul.multi-slider').append(el);
    });

});


sortable = function() {
    if ($('.sortable').length) $('.sortable').sortable({ revert: true });
};

sortableDisable = function() {
    if ($('.sortable').length) $('.sortable').sortable('disable');
}

function addDashes(f) {
    console.log("working", f.value);
    f_val = f.value.replace(/\D[^\.]/g, "");
    f.value = f_val.slice(0, 3) + "-" + f_val.slice(3, 6) + "-" + f_val.slice(6);
}

$(document).ready(function() {

    $('.phone-number, .mobile-number, .nric-number').keypress((event) => {
        if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault(); //stop character from entering input
        }
    });

    $('.nric-number').keyup((event) => {
        let value = event.target.value.toString();
        const regex = /([0-9]{6,6})-?([0-9]{2,2})-?([0-9].*)/gm;
        const regex2 = /([0-9]{6,6})-?([0-9].*)/gm;
        const phone = regex.exec(value);
        const phone2 = regex2.exec(value);
        if (phone) {
            event.target.value = phone[1] + '-' + phone[2] + '-' + phone[3];
            return;
        } else if (phone2) {
            event.target.value = phone2[1] + '-' + phone2[2];
            return;
        }
        event.target.value = value;
    });

    $('.mobile-number').keyup((event) => {
        let value = event.target.value.toString();
        const regex = /([0-9]{3,3})-?([0-9].*)/gm;
        const phone = regex.exec(value);
        if (phone) {
            event.target.value = phone[1] + '-' + phone[2];
            return;
        }
        event.target.value = value;
    });

    if ("geolocation" in navigator) {
        $('.js-geolocation').show();
    } else {
        $('.js-geolocation').hide();
    }

    /* Where in the world are you? */
    $(document).on('click', '.js-geolocation', function() {
        navigator.geolocation.getCurrentPosition(function(position) {
            loadWeather(position.coords.latitude + ',' + position.coords.longitude); //load weather using your lat/lng coordinates
        });
    });

    loadWeather('Kuala Lumpur', '');
    monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    dayNames = ["S", "M", "T", "W", "T", "F", "S"];

    var cTime = new Date(),
        day = cTime.getDay(),
        month = cTime.getMonth() + 1,
        year = cTime.getFullYear();

    var events = [

        {
            "date": day + "/" + month + "/" + year,
            "title": 'Today',
            "link": 'javascript:;',
            "color": 'rgba(255,255,255,0.2)',
        },
        /*
      {
        "date": "7/"+month+"/"+year, 
        "title": 'Kick off meeting!', 
        "link": 'javascript:;', 
        "color": 'rgba(255,255,255,0.2)', 
        "content": 'Have a kick off meeting with .inc company'
      },
      {
        "date": "19/"+month+"/"+year, 
        "title": 'Link to Google', 
        "link": 'http://www.google.com', 
        "color": 'rgba(255,255,255,0.2)', 
      }
	*/
    ];

    $('#calendar-box2').bic_calendar({
        events: events,
        dayNames: dayNames,
        monthNames: monthNames,
        showDays: true,
        displayMonthController: true,
        displayYearController: false,
        popoverOptions: {
            placement: 'top',
            trigger: 'hover',
            html: true
        },
        tooltipOptions: {
            placement: 'top',
            html: true
        }
    });
});

function t(type, text) {
    if (type == "e") {
        icon = "fa fa-exclamation";
        title = 'Error!';
        className = 'error';
    } else if (type == "w") {
        icon = "fa fa-warning";
        title = 'Warning!';
        className = 'warning';
    } else if (type == "s") {
        icon = "fa fa-check";
        title = 'Success!';
        className = 'success';
    } else if (type == "i") {
        icon = "fa fa-question";
        title = 'Information';
        className = 'info';
    } else {
        icon = "fa fa-circle-o";
        title = 'Information';
        className = 'cool';
    }

    $.notify({
        title: title,
        text: text,
        image: "<i class='" + icon + "'></i>"
    }, {
        style: 'metro',
        className: className,
        globalPosition: 'top right',
        showAnimation: 'slideDown',
        hideAnimation: 'slideUp',
        showDuration: 200,
        hideDuration: 200,
        autoHide: true,
        clickToHide: true
    });
}

ajax_form_delivery = function(data, url, dyntable) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: data,
        success: function(results) {
            if (results.error == true) {
                t('e', results.msg);
            } else {
                t('s', results.msg);
                window.location.reload();
            }
        },
        error: function(error) {
            ajax_error(error);
        },
        complete: function() {
            if (dyntable) {
                $(dyntable).dataTable().fnDraw();
                window.location = backUrl;
            }
        }
    });
}

ajax_form = function(data, url, dyntable) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: data,
        success: function(results) {
            if (results.error == true) {
                t('e', results.msg);
            } else {
                t('s', results.msg);
            }
            return false;
        },
        error: function(error) {
            ajax_error(error);
        },
        complete: function() {
            return false;
            if (dyntable) {
                $(dyntable).dataTable().fnDraw();
                window.location = backUrl;
            }
        }
    });
}

ajax_form_action = function(data, url, action) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: data,
        success: function(results) {
            if (results.error == true) {
                t('e', results.msg);
            } else {
                t('s', results.msg);
                setTimeout(function() {
                    if (action == 'reload') window.location.reload();
                    if (action == 'reload') window.location.reload();
                    if (action == 'direct') window.location = results.url;
                    if (action == 'back') {
                        window.location = backUrl;
                    }
                }, 1000);
            }
        },
        error: function(error) {
            ajax_error(error);
        },
        complete: function() {}
    });
}

ajax_error = function(error) {
    if (error.status == 0) {
        t('e', 'You network currently are offline!!');
    } else if (error.status == 404) {
        t('e', 'Requested URL not found.');
    } else if (error.status == 500) {
        t('e', 'Internel Server Error.');
    } else if (error == 'parsererror') {
        t('e', 'Parsing JSON Request failed.');
    } else if (error == 'timeout') {
        t('e', 'Request Time out.');
    } else {
        t('e', 'Unknow Error : ' + error.responseText);
    }
}

kcFinderB = function(image) {
    window.KCFinder = {
        callBack: function(url) {
            var filename = url.substring(url.lastIndexOf('/') + 1);
            val = url.split('upload').pop();
            val = 'upload' + val;
            $('#' + image).val(val);
            $('#' + image).prev('img').remove();
            $('#' + image).before('<img src="' + url + '" style="display:table;margin:5px;max-width:200px;max-height:100px;">');
        }
    }
    window.open(jsPath + 'kcfinder/browse.php?type=images', 'kcfinder_single', 'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=800, height=600');
}

kcFinderC = function(image) {
    $('#' + image).val('');
    $('#' + image).prev('img').attr('src', rootPath + 'assets/img/no_image.jpg');
}

kcFinderR = function(image) {
    el = $('#' + image).parent().attr('class');
    $('#' + image).parent().remove();
    //if( $('.' + el).length > 1 ) $('#'+image).parent().remove();
    //else t('e', 'At least 1 image is required.');
}

loadWeather = function(location, woeid) {
    $.simpleWeather({
        location: location,
        woeid: woeid,
        unit: 'c',
        success: function(weather) {
            html = '<h2><i class="wicon-' + weather.code + '"></i> ' + weather.temp + '&deg;' + weather.units.temp + ' <span class="w-temp2">/ ' + weather.tempAlt + '&deg;F</span></h2>';
            html += '<span class="w-region">' + weather.city + ', ' + weather.region + '</li>';
            html += '<span class="w-currently">' + weather.currently + '</span>';
            html += '';

            $("#weather").html(html);
        },
        error: function(error) {
            $("#weather").html('<p>' + error + '</p>');
        }
    });
}

addMobileNumber = function(event) {
    $('[name="mobile_input"]').removeAttr("required");
    let mobile = $('[name="mobile_input"]').val();
    let html_data = `<div><span class="col-sm-2 control-label"></span><input required type="hidden" name="mobile[]" value="${mobile}"/><span style="display: inline-block; border: 1px solid #ccc; padding: 7px; margin: 0 5px; width: 37%; background-color: #ddd;">${mobile}</span> <span style="padding: 5px 10px; cursor: pointer;" onclick="removeMobileNumber(this)">x</span></div>`;

    const regex = /([0-9]{3,3})-?([0-9]{7,8})/gm;
    const validate = regex.exec(mobile);
    if (validate) {
        $('.mobile-list').append(html_data);
        $('[name="mobile_input"]').val('');
    }
}

removeMobileNumber = function(element) {
    if($('[name="mobile[]"]').length < 2){
        $('[name="mobile_input"]').attr("required", true);
    }    
    let row = $(element).parent('div');
    row.remove();
}
