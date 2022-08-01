@extends('company.app')

@section('title' , __('messages.add_product'))
@push('styles')
    <style>
        .bootstrap-tagsinput .tag {
            color : #3b3f5c
        }
        .bootstrap-tagsinput,
        .bootstrap-tagsinput input {
            width: 100%
        }
        .bootstrap-tagsinput {
            min-height : 45px
        }
        .no-border input {
            border : 0 !important
        }
    </style>
@endpush
@push('scripts')
<script>
    var ss = $(".tags").select2({
        tags: true,
    });
    // inisialize multi select
    $(document).ready(function() {
        $(".multi_tags").select2({
            tags: true
        });
    })
    var language = "{{ Config::get('app.locale') }}",
        select = "{{ __('messages.select') }}"
    $("#category").on("change", function() {
        $('select#brand').html("")
        $("select#sub_category_select").html("")
        var categoryId = $(this).find("option:selected").val();


        $("#properties-items .row").html("")
            $.ajax({
                url : "/company-panel/products/fetchcategoryoptions/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $('#properties-items').show()
                
                    data.forEach(function (option) {
                        var optionName = option.title_en,
                            select = "{{ __('messages.select') }}",
                            anotherChoice = "{{ __('messages.another_choice') }}"
                        if (language == 'ar') {
                            optionName = option.title_ar
                        }
                        var propValOption = ""
                        propValOption += `
                        <option selected value="empty">
                            ${select}
                        </option>
                        `
                        option.values.forEach(function(propVal) {
                        var optionVal = propVal.value_en
                        if (language == 'ar') {
                            optionVal = propVal.value_ar
                        }
                            propValOption += `
                            <option value="${propVal.id}">
                                ${optionVal}
                            </option>
                            `
                        })
                        propValOption += `
                        <option value="0">
                            ${anotherChoice}
                        </option>`
                        var propValSelect = `
                        <select size="1" id="row-1-office" data-property="${option.id}" class="form-control properties-select" name="property_value_id[]">
                            ${propValOption}
                        </select>
                        `
                        $("#properties-items .row").append(`
                        
                        <div class="col-sm-1">${optionName} <input type="hidden" value="${option.id}" name="option_id[]" /> <input type="hidden" name="another_option_en[]" /> <input type="hidden" name="another_option_ar[]" /></div>
                        <div class="col-sm-5">${propValSelect}</div>
                        
                        `)
                    })
                }
            })

            $('select#sub_category_select').html("")
            $('select#sub_category_select').prop("disabled", true)
            $("select#sub_category_select").parent('.form-group').attr("data-next", "0")
            $("select#sub_cartwo_select").parent('.form-group').hide()
            $('select#sub_cartwo_select').prop("disabled", true)
            $("select#sub_cartwo_select").parent('.form-group').removeClass('cat-shown')
            $("select#sub_cartwo_select").parent('.form-group').attr("data-next", "0")
            $("select#main_sections").parent('.form-group').hide()
            $('select#main_sections').prop("disabled", true)
            $("select#main_sections").parent('.form-group').removeClass('cat-shown')
            $("select#main_sections").parent('.form-group').attr("data-next", "0")
            $("select#sub_main_sections").parent('.form-group').hide()
            $('select#sub_main_sections').prop("disabled", true)
            $("select#sub_main_sections").parent('.form-group').removeClass('cat-shown')
            $("select#sub_main_sections").parent('.form-group').attr("data-next", "0")
            $.ajax({
                url : "/company-panel/products/fetchsubcategorybycategory/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $('#sub_category_select').parent('.form-group').show()
                    $('#sub_category_select').parent('.form-group').addClass('cat-shown')
                    $('select#sub_category_select').prop("disabled", false)
                    $('select#sub_category_select').prepend(
                            `<option selected disabled>${select}</option>`
                        )
                    data.forEach(function (subCategory) {
                        var subCategoryName = subCategory.title_en
                        if (language == 'ar') {
                            subCategoryName = subCategory.title_ar
                        }
                        $('select#sub_category_select').append(
                            "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                        )
                    })
                }
            })

        
    })

    $("select#sub_category_select").on("change", function() {
        $("select#sub_cartwo_select").html("")
        var subCarOne = $(this).find("option:selected").val();
        if (subCarOne > 0) {
            $(this).parent('.form-group').attr('data-next', "1")
        }else {
            $(this).parent('.form-group').attr('data-next', "0")
        }
        $.ajax({
            url : "/company-panel/products/fetchsubcartwobycarone/" + subCarOne,
            type : 'GET',
            success : function (data) {
                if (data.length > 0) {
                    $('#sub_cartwo_select').parent('.form-group').show()
                    $('#sub_cartwo_select').parent('.form-group').addClass('cat-shown')
                    $('select#sub_cartwo_select').prop("disabled", false)
                    $('select#sub_cartwo_select').prepend(
                            `<option selected disabled>${select}</option>`
                        )
                    data.forEach(function (subCategory) {
                        var subCategoryName = subCategory.title_en
                        if (language == 'ar') {
                            subCategoryName = subCategory.title_ar
                        }
                        $('select#sub_cartwo_select').append(
                            "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                        )
                    })
                }
            }
        })
    })

    $("select#sub_cartwo_select").on("change", function() {
        $("select#main_sections").html("")
        var subCarTwo = $(this).find("option:selected").val();
        if (subCarTwo > 0) {
            $(this).parent('.form-group').attr('data-next', "1")
        }else {
            $(this).parent('.form-group').attr('data-next', "0")
        }
        $.ajax({
            url : "/company-panel/products/fetchsubcartwobycartwo/" + subCarTwo,
            type : 'GET',
            success : function (data) {
                if (data.length > 0) {
                    $('#main_sections').parent('.form-group').show()
                    $('#main_sections').parent('.form-group').addClass('cat-shown')
                    $('select#main_sections').prop("disabled", false)
                    $('select#main_sections').prepend(
                            `<option selected disabled>${select}</option>`
                        )
                    data.forEach(function (subCategory) {
                        var subCategoryName = subCategory.title_en
                        if (language == 'ar') {
                            subCategoryName = subCategory.title_ar
                        }
                        
                        $('select#main_sections').append(
                            "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                        )
                    })
                }
            }
        })
    })

    $("#main_sections").on("change", function () {
        $("select#sub_main_sections").html("")
        var secId = $(this).find("option:selected").val();
        if (secId > 0) {
            $(this).parent('.form-group').attr('data-next', "1")
        }else {
            $(this).parent('.form-group').attr('data-next', "0")
        }

        $.ajax({
            url : "/company-panel/products/fetchsubcartwobycarthree/" + secId,
            type : 'GET',
            success : function (data) {
                if (data.length > 0) {
                    $('#sub_main_sections').parent('.form-group').show()
                    $('#sub_main_sections').parent('.form-group').addClass('cat-shown')
                    $('select#sub_main_sections').prop("disabled", false)
                    $('select#sub_main_sections').prepend(
                            `<option selected disabled>${select}</option>`
                        )
                    data.forEach(function (subCategory) {
                        var subCategoryName = subCategory.title_en
                        if (language == 'ar') {
                            subCategoryName = subCategory.title_ar
                        }
                        $('select#sub_main_sections').append(
                            "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                        )
                    })
                }
            }
        })
    })

    $("select#sub_main_sections").on("change", function() {
        var subMainSection = $(this).find("option:selected").val()

        if (subMainSection > 0) {
            $(this).parent('.form-group').attr('data-next', "1")
        }else {
            $(this).parent('.form-group').attr('data-next', "0")
        }
    })
    
    $("#brand").on("change", function() {
        $('select#sub_category_select').html("")
        var brandId = $(this).find("option:selected").val();
        
        $.ajax({
            url : "/company-panel/products/fetchsubcategories/" + brandId,
            type : 'GET',
            success : function (data) {
                $('#sub_category_select').parent('.form-group').show()
                $('select#sub_category_select').prop("disabled", false)
                $('select#sub_category_select').prepend(
                        `<option selected disabled>${select}</option>`
                    )
                data.forEach(function (subCategory) {
                    var subCategoryName = subCategory.title_en
                    if (language == 'ar') {
                        subCategoryName = subCategory.title_ar
                    }
                    $('select#sub_category_select').append(
                        "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                    )
                })
            }
        })
    })

    @if (isset($data['cat']))
    var categoryId = $("#category").find("option:selected").val()

    $.ajax({
        url : "/company-panel/products/fetchsubcategorybycategory/" + categoryId,
        type : 'GET',
        success : function (data) {
            if (data.length > 0) {
                $('#sub_category_select').parent('.form-group').show()
                $('#sub_category_select').parent('.form-group').addClass('cat-shown')
                $('select#sub_category_select').prop("disabled", false)
    
                $('select#sub_category_select').prepend(
                        `<option selected disabled>${select}</option>`
                    )
                
                data.forEach(function (subCategory) {
                    var subCategoryName = subCategory.title_en
                    if (language == 'ar') {
                        subCategoryName = subCategory.title_ar
                    }
                   
                    $('select#sub_category_select').append(
                        "<option value='" + subCategory.id + "'>" + subCategoryName+ "</option>"
                    )
                })
            }
        }
    })

    $.ajax({
        url : "/company-panel/products/fetchcategoryoptions/" + categoryId,
        type : 'GET',
        success : function (data) {
            
            $('#properties-items').show()
            
            data.forEach(function (option) {
            
                var optionName = option.title_en,
                    select = "{{ __('messages.select') }}",
                    anotherChoice = "{{ __('messages.another_choice') }}"
                    if (language == 'ar') {
                        optionName = option.title_ar
                    }
                    var propValOption = ""
                    propValOption += `
                    <option value="empty" selected>
                        ${select}
                    </option>
                    `
                    option.values.forEach(function(propVal) {
                    var optionVal = propVal.value_en
                    if (language == 'ar') {
                        optionVal = propVal.value_ar
                    }
                        propValOption += `
                        <option value="${propVal.id}">
                            ${optionVal}
                        </option>
                        `
                    })
                    propValOption += `
                    <option value="0">
                        ${anotherChoice}
                    </option>`
                    var propValSelect = `
                    <select size="1" id="row-1-office" data-property="${option.id}" class="form-control properties-select" name="property_value_id[]">
                        ${propValOption}
                    </select>
                    `
                    $("#properties-items .row").append(`
                    
                    <div class="col-sm-1">${optionName} <input type="hidden" value="${option.id}" name="option_id[]" /> <input type="hidden" name="another_option_en[]" /> <input type="hidden" name="another_option_ar[]" /></div>
                    <div class="col-sm-5">${propValSelect}</div>
                    
                    `)
            })
        }
    })
    @endif

    
        // enable | disable multi options select
        $("#multi_options_radio .row").on('change', 'input[type="radio"]', function() {
            var multiId = $(this).data('multi')
            if ($(this).is(":checked")) {
                $("select.multi_tags").prop('disabled', true)
                $(`#${multiId}`).prop('disabled', false)
                $(`#${multiId}`).prop('required', true)
                $(`#${multiId}`).parent('.col-sm-4').siblings('.col-sm-4').children('select').prop('required', false)
            }
        })

        
        // if none checked then show single product elements
        $("#multi_options_radio .row").on("change", "input[type='radio']", function() {
            if ($(this).val() == "none") {
                $("#example tbody").html('')
                $("#multi-options-details").hide()
                $("#single-details").show()
                $("#single-discount").show()
            }else {
                $("#multi-options-details").show()
                $("#single-details").hide()
                $("#single-discount").hide()
            }
        })

        // set multi options values
        $("#multi_options_radio .row").on('change', 'select.multi_tags', function() {
            var selectId = $(this).attr('id')
            if ($(this).val().length > 0) {
                $("#multi-options-details").show()
                $("#single-details").hide()
                $("#single-discount").hide()
            }else {
                $("#multi-options-details").hide()
                $("#single-details").show()
                $("#single-discount").show()
            }
            
            $("#example tbody").html('')
            var optionsText = []
            $(this).find("option:selected").each(function () {
                optionsText.push($(this).text())
            })
            
            for (var i = 0; i < $(this).val().length; i ++) {
                $("#example tbody").append(`
                <tr>
                    <td><i style="color : red; cursor:pointer" data-option="${selectId}" class="fa fa-trash" aria-hidden="true"></i> ${optionsText[i]} <input type="hidden" name="multi_option_value_id[]" value="${$(this).val()[i]}" /></td>
                    <td><input style="border : 1px solid red" type="number" required class="form-control" name="total_amount[]" ></td>
                    <td><input style="border : 1px solid red" type="number" required class="form-control" name="remaining_amount[]" ></td>
                    <td><input style="border : 1px solid red" type="number" step="any" min="0" required class="form-control" name="final_price[]" ></td>
                    <td><input unique="1" type="text" class="form-control" name="barcodes[]" ></td>
                    <td><input unique="1" type="text" class="form-control" name="stored_numbers[]" ></td>
                </tr>
                `)
            }
            
        })

        // remove multi option row
        $("#example tbody").on("click", "tr td .fa-trash", function () {
            var elementVal = $(this).siblings('input').val(),
                optionId = $(this).data('option'),
                valArray = $("#multi_options_radio .row").find("select#" + optionId).val()
                
            var index = valArray.indexOf(elementVal)

                
                if (index > -1) {
                    valArray.splice(index, 1);
                }
                
                if (valArray.length > 0) {
                    
                    var textOptions = []
                      $("#multi_options_radio .row").find("select#" + optionId).find("option").each(function () {
                        var $this = $(this);
                        if ($this.length) {
                            var selText = $this.text().trim();
                            textOptions.push(selText)
                        }
                    });
                    var avlsOptions = []
                      $("#multi_options_radio .row").find("select#" + optionId).find("option").each(function () {
                        var $this = $(this);
                        if ($this.length) {
                            var selVal = $this.val();
                            avlsOptions.push(selVal)
                        }
                    });
                    var optionsEle = ""
                    for (var k = 0; k < avlsOptions.length; k ++) {
                        var selected = ""

                        if (valArray.includes(avlsOptions[k])) {
                            selected = "selected"
                        }
                        optionsEle += `
                        <option ${selected} value="${avlsOptions[k]}">${textOptions[k]}</option>
                        `
                    }
                    $("#multi_options_radio .row").find("select#" + optionId).html(optionsEle)
                    $(this).parent('td').parent('tr').remove()
                }
        })

        // change discount value on change price in each multi option
        $("#example tbody").on('keyup', 'tr td input[name="final_price[]"]', function() {
            var priceVal = $(this).val(),
                discountValue = $("#offer_percentage").val(),
                discountNumber = Number(priceVal) * (Number(discountValue) / 100),
                total = Number(priceVal) - discountNumber

            $(this).parent("td").next('td').children('input[disabled="disabled"]').val(total)
            $(this).parent("td").next('td').children('input[name="price_after_discount[]"]').val(total)
        })

       
        
        // action on checked discount
        $("#discount").click(function() {
            if ($(this).is(':checked')) {
                $("#offer_percentage").parent(".form-group").show()
                $("#offer_percentage").prop('disabled', false)
                if ($("#example tbody").children("tr").length > 0) {
                    $(".th-discount").show()
                    for (var n = 0; n < $("#example tbody").children("tr").length; n ++) {
                        console.log($("#example tbody").children("tr").eq(n).children('td').eq(4).children('input').attr('name'))
                        $("#example tbody").children("tr").eq(n).children('td').eq(3).after(`
                        <td><input type="text" disabled class="form-control" > <input type="hidden" class="form-control" name="price_after_discount[]" ></td>
                        `)
                    }
                }else {
                    
                    $("#final_price").parent(".form-group").show()
                }
                
            }else {
                $("#offer_percentage").parent(".form-group").hide()
                $("#offer_percentage").prop('disabled', true)
                if ($("#example tbody").children("tr").length > 0) {
                    $(".th-discount").hide()
                    for (var n = 0; n < $("#example tbody").children("tr").length; n ++) {
                        $("#example tbody").children("tr").eq(n).children('td').eq(4).remove()
                    }
                }else {
                    $("#final_price").parent(".form-group").hide()
                }
            }
        })

    // add another option
    $("#properties-items .row").on('click', 'select', function() {
        var valEn = "{{ __('messages.value_en') }}",
            valAr = "{{ __('messages.value_ar') }}"
        if ($(this).val() == 0) {
            $(this).parent('.col-sm-5').prev('.col-sm-1').find("input[name='another_option_en[]']").prop('disabled', true)
            $(this).parent('.col-sm-5').prev('.col-sm-1').find("input[name='another_option_ar[]']").prop('disabled', true)
            $(this).siblings("input").remove()
            $(this).after(`<input style="margin-top:20px; border: 1px solid red" type="text" placeholder="${valEn}" name="another_option_en[]" class="form-control" >
            <input style="margin-top:20px; border: 1px solid red" type="text" placeholder="${valAr}" name="another_option_ar[]" class="form-control" >
            `)
        }else {
            $(this).parent('.col-sm-5').prev('.col-sm-1').find("input[name='another_option_en[]']").prop('disabled', false)
            $(this).parent('.col-sm-5').prev('.col-sm-1').find("input[name='another_option_ar[]']").prop('disabled', false)
            $(this).siblings("input").remove()
        }
    })
          
        // show price after discount
        $("#offer_percentage").on("keyup", function () {
            if ($("#example tbody").children("tr").length > 0) {
                
                for (var m = 0; m < $("#example tbody").children("tr").length; m ++) {
                    var discountValue = $("#offer_percentage").val(),
                        price = $("#example tbody").children("tr").eq(m).children('td').eq(3).children("input").val(),
                        discountNumber = Number(price) * (Number(discountValue) / 100),
                        total = Number(price) - discountNumber
                        
                        
                    $("#example tbody").children("tr").eq(m).children('td').eq(4).children("input").eq(0).val(total)
                    $("#example tbody").children("tr").eq(m).children('td').eq(4).children("input").eq(1).val(total)
                }
            }else {
                var discountValue = $("#offer_percentage").val(),
                price = $("#price_before_offer").val(),
                discountNumber = Number(price) * (Number(discountValue) / 100),
                total = Number(price) - discountNumber
                $("#final_price").val(total)
            }
            
        })

        $("#category_options .row").on('click', 'input', function() {
            var label = $(this).data("label"),
                    labelEn = "English " + label,
                    labelAr = "Arabic " + label,
                    elementValue = $(this).val() + "element",
                    optionId = $(this).val()
               
               if (language == 'ar') {
                    labelEn = label + " باللغة الإنجليزية"
                    labelAr = label + " باللغة العربية"
               }
           if($(this).is(':checked')) {
                $("#category_options_sibling").append(`
                <div class="form-group mb-4 ${elementValue}">
                    <label for="title_en">${labelEn}</label>
                    <input required type="text" name="value_en[]" class="form-control" id="title_en" placeholder="${labelEn}" value="" >
                </div>
                <div class="form-group mb-4 ${elementValue}">
                    <label for="title_en">${labelAr}</label>
                    <input required type="text" name="value_ar[]" class="form-control" id="title_en" placeholder="${labelAr}" value="" >
                </div>
                <input name="option[]" value="${optionId}" type="hidden" class="new-control-input ${elementValue}">
                `)
           }else {
               console.log("." + elementValue)
            $("." + elementValue).remove()
           }
        })

        $("#add_home").on("change", function() {
            if ($(this).is(':checked')) {
                $("#home_section").prop("disabled", false)
                $("#home_section").parent(".form-group").show()
            }else {
                $("#home_section").prop("disabled", true)
                $("#home_section").parent(".form-group").hide()
            }
        })

        
        var previous = "{{ __('messages.previous') }}",
            next = "{{ __('messages.next') }}",
            finish = "{{ __('messages.finish') }}"

        // translate three buttons
        $(".actions ul").find('li').eq(0).children('a').text(previous)
        $(".actions ul").find('li').eq(1).children('a').text(next)
        $(".actions ul").find('li').eq(2).children('a').text(finish)

        // add class next1 to next button to control the first section
        $(".actions ul").find('li').eq(1).children('a').addClass("next1")
        
        // section one validation
        $(".actions ul").find('li').eq(1).on("mouseover", "a.next1", function() {
            var image = $('input[name="images[]"]').val(),
                categorySelect = $("#category").val(),
                subCarOneSelect = $("#sub_category_select").val(),
                subCarTwoSelect = $("#sub_cartwo_select").val(),
                mainSectionSelect = $("#main_sections").val(),
                subMainSectionSelect = $("#sub_main_sections").val(),
                companySelect = $("#companies_select").val(),
                weightInput = $("#weight").val(),
                countrySelect = $("#origin_country").val(),
                shownLength = $(".sub-cat-containers").find('.cat-shown').length,
                nextLength = $(".sub-cat-containers").find('*[data-next="1"]').length,
                yearInput = $("select#compatible").val(),
                titleEnInput = $("input[name='title_en']").val(),
                titleArInput = $("input[name='title_ar']").val(),
                descriptionEnText = $('textarea[name="description_en"]').val(),
                descriptionArText = $('textarea[name="description_ar"]').val()

            
            if (image.length > 0 && categorySelect > 0 && titleEnInput.length > 0 && titleArInput.length > 0 && descriptionEnText.length > 0 && descriptionArText.length > 0 && ($(".sub-cat-containers").find('*[data-next="1"]') && shownLength == nextLength) && yearInput.length > 0 && weightInput.length > 0 && countrySelect.length > 0) {
                $(this).attr('href', '#next')
                $(this).addClass('next2')
            }else {
                $(this).attr('href', '#')
            }
            
        })

        // show validation messages on section 1
        $(".actions ul").find('li').eq(1).on("click", "a[href='#']", function () {
            var image = $('input[name="images[]"]').val(),
                categorySelect = $("#category").val(),
                subCarOneSelect = $("#sub_category_select").val(),
                subCarTwoSelect = $("#sub_cartwo_select").val(),
                mainSectionSelect = $("#main_sections").val(),
                subMainSectionSelect = $("#sub_main_sections").val(),
                companySelect = $("#companies_select").val(),
                yearInput = $("select#compatible").val(),
                titleEnInput = $("input[name='title_en']").val(),
                titleArInput = $("input[name='title_ar']").val(),
                descriptionEnText = $('textarea[name="description_en"]').val(),
                descriptionArText = $('textarea[name="description_ar"]').val(),
                countrySelect = $("#origin_country").val(),
                weightInput = $("#weight").val(),
                subCarTwoRequired = "{{ __('messages.model_required') }}",
                mainSectionRequired = "{{ __('messages.section_required') }}",
                subMainSectionRequired = "{{ __('messages.subsection_required') }}",
                companyRequired = "{{ __('messages.company_required') }}",
                yearRequired = "{{ __('messages.year_required') }}",
                imagesRequired = "{{ __('messages.images_required') }}",
                categoryRequired = "{{ __('messages.category_required') }}",
                subCategoryRequired = "{{ __('messages.sub_category_required') }}",
                titleEnRequired = "{{ __('messages.title_en_required') }}",
                titleArRequired = "{{ __('messages.title_ar_required') }}",
                descriptionEnRequired = "{{ __('messages.description_en_required') }}",
                descriptionArRequired = "{{ __('messages.description_ar_required') }}",
                countryRequired = "{{ __('messages.country_required') }}",
                weightRequired = "{{ __('messages.weight_required') }}"

            
            if (image.length == 0) {
                if ($(".image-required").length) {
                    
                }else {
                    $('input[name="images[]"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 image-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${imagesRequired}</div>
                    `)
                }
            }else {
                $(".image-required").remove()
            }

            if (countrySelect && countrySelect.length > 0) {
                $(".country-required").remove()
            }else {
                if ($(".country-required").length) {

                }else {
                    $("#origin_country").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 country-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${countryRequired}</div>
                    `)
                }
            }
            
            if (categorySelect > 0) {
                $(".category-required").remove()
            }else {
                if ($(".category-required").length) {

                }else {
                    $("#category").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 category-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${categoryRequired}</div>
                    `)
                }
            }

            if (subCarOneSelect > 0) {
                $(".sub-category-required").remove()
            }else {
                if ($(".sub-category-required").length) {

                }else {
                    $("#sub_category_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 sub-category-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subCategoryRequired}</div>
                    `)
                }
            }

            if (subCarTwoSelect > 0) {
                $(".sub-car-two-required").remove()
            }else {
                if ($(".sub-car-two-required").length) {

                }else {
                    $("#sub_cartwo_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 sub-car-two-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subCarTwoRequired}</div>
                    `)
                }
            }

            if (mainSectionSelect > 0) {
                $(".main-section-required").remove()
            }else {
                if ($(".main-section-required").length) {

                }else {
                    $("#main_sections").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 main-section-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${mainSectionRequired}</div>
                    `)
                }
            }

            if (subMainSectionSelect > 0) {
                $(".submain-section-required").remove()
            }else {
                if ($(".submain-section-required").length) {

                }else {
                    $("#sub_main_sections").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 submain-section-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subMainSectionRequired}</div>
                    `)
                }
            }

            if (companySelect > 0) {
                $(".company-required").remove()
            }else {
                if ($(".company-required").length) {

                }else {
                    $("#companies_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 company-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${companyRequired}</div>
                    `)
                }
            }

            if (weightInput.length == 0) {
                if ($(".weight-required").length) {

                }else {
                    $("#weight").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 weight-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${weightRequired}</div>
                    `)
                }
            }else {
                $(".weight-required").remove()
            }

            if (yearInput.length > 0) {
                $(".year-required").remove()
                
            }else {
                if ($(".year-required").length) {

                }else {
                    $("select#compatible").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 year-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${yearRequired}</div>
                    `)
                }
            }

            if (titleEnInput.length == 0) {
                if ($(".titleEn-required").length) {

                }else {
                    $("input[name='title_en']").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 titleEn-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${titleEnRequired}</div>
                    `)
                }
            }else {
                $(".titleEn-required").remove()
            }

            if (titleArInput.length == 0) {
                if ($(".titleAr-required").length) {

                }else {
                    $("input[name='title_ar']").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 titleAr-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${titleArRequired}</div>
                    `)
                }
            }else {
                $(".titleAr-required").remove()
            }

            if (descriptionEnText.length == 0) {
                if ($(".descEn-required").length) {

                }else {
                    $('textarea[name="description_en"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 descEn-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${descriptionEnRequired}</div>
                    `)
                }
            }else {
                $(".descEn-required").remove()
            }

            if (descriptionArText.length == 0) {
                if ($(".descAr-required").length) {

                }else {
                    $('textarea[name="description_ar"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 descAr-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${descriptionArRequired}</div>
                    `)
                }
            }else {
                $(".descAr-required").remove()
            }
        })

        //section two | three | four validation
        $(".actions ul").find('li').eq(1).on('click', function() {
            console.log("SGFDDFFD")
            var fieldRequired = "{{ __('messages.field_required') }}",
                remaininiLessTotal = "{{ __('messages.remaining_q_less_total') }}"

            //section two
            if ($(".steps ul").find('li').eq(1).hasClass('current')) {
                $("#properties-items").on("change", ".row .col-sm-5 select", function() {
                    if ($(this).val() == 0) {
                        $(this).attr('href', "#")
                        console.log("zero")
                        $(this).parent('.col-sm-5').on("keyup", "input", function () {
                            
                            if ($(this).val().length > 0) {
                                $(this).css('border', '#CCC solid 1px')
                                $(this).attr('valid', '1')
                            }else {
                                $(this).css('border', 'red solid 1px')
                                $(this).attr('valid', '0')
                            }
                        })
                    }else {
                        console.log("int")
                        $(this).attr('href', "#next")
                    }
                })
                // validate if all inputs are not empty
                $(".actions ul").find('li').eq(1).on("mouseover", "a", function() {
                    
                    if ($("#properties-items .row").find(".col-sm-5 input[name='another_option_en[]']").length > 0) {
                        var countInputsEn = $("#properties-items .row").find(".col-sm-5 input[name='another_option_en[]']").length,
                            countInputsAr = $("#properties-items .row").find(".col-sm-5 input[name='another_option_ar[]']").length,
                            countInputs = Number(countInputsEn) + Number(countInputsAr),
                            countValid = $("#properties-items .row").find(".col-sm-5 input[valid='1']").length

                        if (countInputs != Number(countValid)) {
                            $(this).attr('href', "#")
                        }else {
                            $(this).attr('href', "#next")
                        }
                    }
                })
            }
            
            // section three
            if ($(".steps ul").find('li').eq(2).hasClass('current')) {
                $(".actions ul").find('li').eq(2).on("mouseover", "a", function() {
                    var totalQRequired = "{{ __('messages.total_quantity_required') }}",
                        remainingQRequired = "{{ __('messages.remaining_quantity_required') }}",
                        priceRequired = "{{ __('messages.price_required') }}",
                        offerRequired = "{{ __('messages.offer_required') }}",
                        remainingQLess = "{{ __('messages.remaining_q_less_total') }}"

                        
                    $("input[name='total_quatity']").on('keyup', function() {
                        if ( !$(this).val() ) {
                            $(this).attr('valid', "0")
                            if ($(this).next('.offerV-required').length) {

                            }else {
                                $(this).after(`
                                <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${totalQRequired}</div>
                                `)
                            }
                        }else {
                            $(this).attr('valid', "1")
                            $(this).next('.offerV-required').remove()
                        }
                    })

                    $("input[name='remaining_quantity']").on('keyup', function() {
                        var remainingQ = $(this).val(),
                            totalQ = $("input[name='total_quatity']").val()
                        if ( !$(this).val() || Number(remainingQ) > Number(totalQ) ) {
                            $(this).attr('valid', "0")
                            
                            if (Number(remainingQ) > Number(totalQ)) {
                                if ($(this).next('.offerV-required').length) {

                                }else {
                                    $(this).after(`
                                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${remainingQLess} ${totalQ}</div>
                                    `)
                                }
                            }else {
                                if ($(this).next('.offerV-required').length) {

                                }else {
                                    $(this).after(`
                                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${remainingQRequired}</div>
                                    `)
                                }
                            }
                            
                        }else {
                            $(this).attr('valid', "1")
                            $(this).next('.offerV-required').remove()
                        }
                    })

                    $("input[name='price_before_offer']").on('keyup', function() {
                        if ( !$(this).val() ) {
                            $(this).attr('valid', "0")
                            if ($(this).next('.offerV-required').length) {

                            }else {
                                $(this).after(`
                                <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${priceRequired}</div>
                                `)
                            }
                        }else {
                            $(this).attr('valid', "1")
                            $(this).next('.offerV-required').remove()
                        }
                    })

                    $("#offer_percentage").on('keyup', function() {
                        if ( !$(this).val() ) {
                            $(this).attr('valid', "0")
                            if ($(this).next('.offerV-required').length) {

                            }else {
                                $(this).after(`
                                <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${offerRequired}</div>
                                `)
                            }
                        }else {
                            $(this).attr('valid', "1")
                            $(this).next('.offerV-required').remove()
                        }
                    })
                

                // validation on click section 3     
                if ($("#discount").is(":checked")) {
                    if ($("input[name='price_before_offer']").attr('valid') == "1" && 
                        $("input[name='remaining_quantity']").attr('valid') == "1" && 
                        $("input[name='total_quatity']").attr('valid') == "1" &&
                        $("input[name='offer_percentage']").attr('valid') == "1") {
                            $(this).attr('href', "#finish")
                        }else {
                            $(this).attr('href', "#")
                        }
                }else {
                    if ($("input[name='price_before_offer']").attr('valid') == "1" && 
                    $("input[name='remaining_quantity']").attr('valid') == "1" && 
                    $("input[name='total_quatity']").attr('valid') == "1") {
                        $(this).attr('href', "#finish")
                    }else {
                        $(this).attr('href', "#")
                    }
                }
                })
                    
            }
        })

        

        /*
        *  show / hide message on change value
        */
        
        // image
        $('input[name="images[]"]').on("change", function() {
            var image = $('input[name="images[]"]').val(),
                imagesRequired = "{{ __('messages.images_required') }}"

            if (image.length > 0) {
                if ($(".image-required").length) {
                    $(".image-required").remove()
                }
            }else {
                if ($(".image-required").length) {
                    
                }else {
                    $('input[name="images[]"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 image-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${imagesRequired}</div>
                    `)
                }
            }
        })

        // origin country
        $("#origin_country").on("change", function() {
            var countrySelect = $(this).val(),
                countryRequired = "{{ __('messages.country_required') }}"

            if (countrySelect.length > 0) {
                if ($(".country-required").length) {
                    $(".country-required").remove()
                } 
            }else {
                if ($(".country-required").length) {

                }else {
                    $("#origin_country").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 country-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${countryRequired}</div>
                    `)
                }
            }
        })

        // weight
        $("#weight").on("change", function() {
            var weightInput = $(this).val(),
                weightRequired = "{{ __('messages.weight_required') }}"

            if (weightInput.length > 0) {
                if ($(".weight-required").length) {
                    $(".weight-required").remove()
                } 
            }else {
                if ($(".weight-required").length) {

                }else {
                    $("#weight").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 weight-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${weightRequired}</div>
                    `)
                }
            }
        })

        // category
        $("#category").on("change", function() {
            var categorySelect = $("#category").val(),
                categoryRequired = "{{ __('messages.category_required') }}"

            if (categorySelect > 0) {
                if ($(".category-required").length) {
                    $(".category-required").remove()
                }
            }else {
                if ($(".category-required").length) {

                }else {
                    $("#category").after(`
                        <div style="margin-top:20px" class="alert alert-outline-danger mb-4 category-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${categoryRequired}</div>
                        `)
                }
            }
        })

        // sub car one
        $("#sub_category_select").on("change", function() {
            var subCategorySelect = $("#sub_category_select").val(),
                subCategoryRequired = "{{ __('messages.sub_category_required') }}"

            if (subCategorySelect > 0) {
                if ($(".sub-category-required").length) {
                    $(".sub-category-required").remove()
                } 
            }else {
                if ($(".sub-category-required").length) {

                }else {
                    $("#sub_category_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 sub-category-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subCategoryRequired}</div>
                    `)
                }
            }
        })

        // sub car two
        $("#sub_cartwo_select").on("change", function() {
            var subCarTwoSelect = $("#sub_cartwo_select").val(),
                subCarTwoRequired = "{{ __('messages.model_required') }}"

            if (subCarTwoSelect > 0) {
                if ($(".sub-car-two-required").length) {
                    $(".sub-car-two-required").remove()
                } 
            }else {
                if ($(".sub-car-two-required").length) {

                }else {
                    $("#sub_cartwo_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 sub-car-two-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subCarTwoRequired}</div>
                    `)
                }
            }
        })

        // main section
        $("#main_sections").on("change", function() {
            var mainSectionSelect = $("#main_sections").val(),
                mainSectionRequired = "{{ __('messages.section_required') }}"

            if (mainSectionSelect > 0) {
                if ($(".main-section-required").length) {
                    $(".main-section-required").remove()
                } 
            }else {
                if ($(".main-section-required").length) {

                }else {
                    $("#main_sections").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 main-section-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${mainSectionRequired}</div>
                    `)
                }
            }
        })

        // sub main section
        $("#sub_main_sections").on("change", function() {
            var subMainSectionSelect = $("#sub_main_sections").val(),
                subMainSectionRequired = "{{ __('messages.subsection_required') }}"

            if (subMainSectionSelect > 0) {
                if ($(".submain-section-required").length) {
                    $(".submain-section-required").remove()
                } 
            }else {
                if ($(".submain-section-required").length) {

                }else {
                    $("#sub_main_sections").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 submain-section-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${subMainSectionRequired}</div>
                    `)
                }
            }
        })

        // company
        $("#companies_select").on("change", function() {
            var companySelect = $("#companies_select").val(),
                companyRequired = "{{ __('messages.company_required') }}"

            if (companySelect > 0) {
                if ($(".company-required").length) {
                    $(".company-required").remove()
                } 
            }else {
                if ($(".company-required").length) {

                }else {
                    $("#companies_select").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 company-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${companyRequired}</div>
                    `)
                }
            }
        })

        // year
        $("input[name='year']").on("keyup", function() {
            var yearInput = $("input[name='year']").val(),
                yearRequired = "{{ __('messages.year_required') }}"

            if (yearInput.length > 0) {
                if ($(".year-required").length) {
                    $(".year-required").remove()
                }
            }else {
                if ($(".year-required").length) {
                    
                }else {
                    $("input[name='year']").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 year-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${yearRequired}</div>
                    `)
                }
            }
        })

        // title en
        $("input[name='title_en']").on("keyup", function() {
            var titleEnInput = $("input[name='title_en']").val(),
                titleEnRequired = "{{ __('messages.title_en_required') }}"

            if (titleEnInput.length > 0) {
                if ($(".titleEn-required").length) {
                    $(".titleEn-required").remove()
                }
            }else {
                if ($(".titleEn-required").length) {
                    
                }else {
                    $("input[name='title_en']").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 titleEn-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${titleEnRequired}</div>
                    `)
                }
            }
        })

        // title ar
        $("input[name='title_ar']").on("keyup", function() {
            var titleArInput = $("input[name='title_ar']").val(),
                titleArRequired = "{{ __('messages.title_ar_required') }}"

            if (titleArInput.length > 0) {
                if ($(".titleAr-required").length) {
                    $(".titleAr-required").remove()
                }
            }else {
                if ($(".titleAr-required").length) {
                    
                }else {
                    $("input[name='title_ar']").after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 titleAr-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${titleArRequired}</div>
                    `)
                }
            }
        })

        // description en
        $('textarea[name="description_en"]').on("keyup", function() {
            var descriptionEnText = $('textarea[name="description_en"]').val(),
                descriptionEnRequired = "{{ __('messages.description_en_required') }}"

            if (descriptionEnText.length > 0) {
                if ($(".descEn-required").length) {
                    $(".descEn-required").remove()
                }
            }else {
                if ($(".descEn-required").length) {

                }else {
                    $('textarea[name="description_en"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 descEn-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${descriptionEnRequired}</div>
                    `)
                }
            }
        })
        
        // description ar
        $('textarea[name="description_ar"]').on("keyup", function() {
            var descriptionArText = $('textarea[name="description_ar"]').val(),
                descriptionArRequired = "{{ __('messages.description_ar_required') }}"

            if (descriptionArText.length > 0) {
                if ($(".descAr-required").length) {
                    $(".descAr-required").remove()
                }
            }else {
                if ($(".descAr-required").length) {

                }else {
                    $('textarea[name="description_ar"]').after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 descAr-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${descriptionArRequired}</div>
                    `)
                }
            }
        })

        var totalQRequired = "{{ __('messages.total_quantity_required') }}",
            remainingQRequired = "{{ __('messages.remaining_quantity_required') }}",
            priceRequired = "{{ __('messages.price_required') }}",
            offerRequired = "{{ __('messages.offer_required') }}",
            remainingQLess = "{{ __('messages.remaining_q_less_total') }}"

            
        $("input[name='total_quatity']").on('keyup', function() {
            console.log("DDDS")
            if ( !$(this).val() ) {
                $(this).attr('valid', "0")
                if ($(this).next('.offerV-required').length) {

                }else {
                    $(this).after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${totalQRequired}</div>
                    `)
                }
            }else {
                $(this).attr('valid', "1")
                $(this).next('.offerV-required').remove()
            }
        })

        $("input[name='remaining_quantity']").on('keyup', function() {
            var remainingQ = $(this).val(),
                totalQ = $("input[name='total_quatity']").val()
            if ( !$(this).val() || Number(remainingQ) > Number(totalQ) ) {
                $(this).attr('valid', "0")
                
                if (Number(remainingQ) > Number(totalQ)) {
                    if ($(this).next('.offerV-required').length) {

                    }else {
                        $(this).after(`
                        <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${remainingQLess} ${totalQ}</div>
                        `)
                    }
                }else {
                    if ($(this).next('.offerV-required').length) {

                    }else {
                        $(this).after(`
                        <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${remainingQRequired}</div>
                        `)
                    }
                }
                
            }else {
                $(this).attr('valid', "1")
                $(this).next('.offerV-required').remove()
            }
        })

        $("input[name='price_before_offer']").on('keyup', function() {
            if ( !$(this).val() ) {
                $(this).attr('valid', "0")
                if ($(this).next('.offerV-required').length) {

                }else {
                    $(this).after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${priceRequired}</div>
                    `)
                }
            }else {
                $(this).attr('valid', "1")
                $(this).next('.offerV-required').remove()
            }
        })

        $("#offer_percentage").on('keyup', function() {
            if ( !$(this).val() ) {
                $(this).attr('valid', "0")
                if ($(this).next('.offerV-required').length) {

                }else {
                    $(this).after(`
                    <div style="margin-top:20px" class="alert alert-outline-danger mb-4 offerV-required" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i> ${offerRequired}</div>
                    `)
                }
            }else {
                $(this).attr('valid', "1")
                $(this).next('.offerV-required').remove()
            }
        })

        $("input[name='air_shipping']").on('change', function() {
            if ($(this).is(':checked')) {
                $(".air_shipping_price").show()
                $(".air_shipping_price").find("#air_shipping_price").prop('disabled', false)
            }else {
                $(".air_shipping_price").hide()
                $(".air_shipping_price").find("#air_shipping_price").prop('disabled', true)
            }
        })

        $("input[name='sea_shipping']").on('change', function() {
            if ($(this).is(':checked')) {
                $(".sea_shipping_price").show()
                $(".sea_shipping_price").find("#sea_shipping_price").prop('disabled', false)
            }else {
                $(".sea_shipping_price").hide()
                $(".sea_shipping_price").find("#sea_shipping_price").prop('disabled', true)
            }
        })



        
        

        // submit form on click finish
        $(".actions ul").find('li').eq(2).on("click", 'a[href="#finish"]', function () {
            $("form").submit()
        })
        
</script>
@endpush

@section('content')

    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_product') }}</h4>
                 </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div id="circle-basic" class="">
                        <h3>{{ __('messages.product_details') }}</h3>
                        <section>
                            <div class="custom-file-container" data-upload-id="myFirstImage">
                                <label>{{ __('messages.upload') }} ({{ __('messages.multiple_image') }}) * <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                <label class="custom-file-container__custom-file" >
                                    <input type="file" required name="images[]" multiple class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                </label>
                                <div class="custom-file-container__image-preview"></div>
                            </div>
                
                            <div class="form-group">
                                <label for="category">{{ __('messages.category') }} *</label>
                                <select id="category" name="car_type_id" class="form-control">
                                    <option selected>{{ __('messages.select') }}</option>
                                    @foreach ( $data['categories'] as $category )
                                    <option {{ old('category_id') == $category->id ? 'selected' : '' }} {{ isset($data['cat']) && $data['cat'] == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ App::isLocale('en') ? $category->title_en : $category->title_ar }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sub-cat-containers">
                                <div data-next="0" style="display: none" class="form-group">
                                    <label for="sub_category_select">{{ __('messages.sub_one_car_types') }}</label>
                                    <select required id="sub_category_select" name="sub_one_car_type_id" class="form-control">
                                    </select>
                                </div>
    
                                <div data-next="0" style="display: none" class="form-group">
                                    <label for="sub_cartwo_select">{{ __('messages.sub_two_car_types') }}</label>
                                    <select required id="sub_cartwo_select" name="sub_two_car_type_id" class="form-control">
                                    </select>
                                </div>
    
                                <div data-next="0" style="display: none" class="form-group">
                                    <label for="main_sections">{{ __('messages.section') }}</label>
                                    <select id="main_sections" name="category_id" class="form-control">
                                        
                                    </select>
                                </div>
    
                                <div data-next="0" style="display: none" class="form-group">
                                    <label for="sub_main_sections">{{ __('messages.sub_section') }}</label>
                                    <select required id="sub_main_sections" name="sub_category_id" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="origin_country">{{ __('messages.origin_country') }} *</label>
                                <select id="origin_country" name="origin_country" class="form-control">
                                    <option disabled selected>{{ __('messages.select') }}</option>
                                    @foreach ( $data['origin_countries'] as $country )
                                    <option {{ old('origin_country') == $country->id ? 'selected' : '' }} value="{{ $country->country_code }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                            $already_selected_value = 1984;
                            $earliest_year = 1950;                            
                            @endphp
                            <div class="form-group no-border">
                                <label for="compatible">{{ __('messages.compatible_with') }}</label>
                                <select id="compatible" name="compatible[]" class="form-control tags" multiple="multiple">
                                    @foreach (range(date('Y'), $earliest_year) as $x)
                                    <option value="{{ $x }}">{{ $x }}</option>
                                    @endforeach
                                </select>
                            </div>
                          
                            <div class="form-group mb-4">
                                <label for="title_en">{{ __('messages.title_en') }} ( {{ __('messages.desc_must') }} ) *</label>
                                <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="{{ old('title_en') }}" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="title_ar">{{ __('messages.title_ar') }} *</label>
                                <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="{{ old('title_ar') }}" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="weight">{{ __('messages.weight') }} ( {{ __('messages.kg') }} ) *</label>
                                <input required type="number" step="any" min="0.000" name="weight" class="form-control" id="weight" placeholder="{{ __('messages.weight') }}" value="{{ old('weight') }}" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="width">{{ __('messages.width') }}</label>
                                <input type="number" step="any" min="0.000" name="width" class="form-control" id="weight" placeholder="{{ __('messages.width') }}" value="{{ old('width') }}" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="length">{{ __('messages.length') }}</label>
                                <input type="number" step="any" min="0.000" name="length" class="form-control" id="length" placeholder="{{ __('messages.length') }}" value="{{ old('length') }}" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="height">{{ __('messages.height') }}</label>
                                <input type="number" step="any" min="0.000" name="height" class="form-control" id="height" placeholder="{{ __('messages.height') }}" value="{{ old('height') }}" >
                            </div>
                            <div class="form-group mb-4 english-direction" >
                                <label for="demo1">{{ __('messages.english') }} ( {{ __('messages.desc_must') }} ) *</label>
                                <textarea required name="description_en" class="form-control"  rows="5">{{ old('description_en') }}</textarea>
                            </div>
                
                            <div class="form-group mb-4 arabic-direction">
                                <label for="demo2">{{ __('messages.arabic') }} *</label>
                                <textarea name="description_ar" required  class="form-control"  rows="5">{{ old('description_ar') }}</textarea>
                            </div> 

                            <div class="form-group mb-4" >
                                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                  <input name="type" checked value="1" type="radio" class="new-control-input">
                                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.new') }}</span>
                                </label>
                                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                    <input name="type" value="2" type="radio" class="new-control-input">
                                    <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.used') }}</span>
                                  </label>
                                  <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                    <input name="type" value="3" type="radio" class="new-control-input">
                                    <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.commercial') }}</span>
                                </label>
                            </div> 
                        </section>
                        <h3>{{ __('messages.product_specification') }} ( {{ __('messages.optional') }} )</h3>
                        <section>
                            <div id="category_options" style="margin-bottom: 20px" class="col-md-3" >
                                <label> {{ __('messages.properties') }} </label>
                            </div>
                            
                            <div style="display: none" id="properties-items" class="table table-hover" style="width:100%">
                                <div class="row">

                                </div>
                            </div>
                        </section>
                        
                        <h3>{{ __('messages.prices_and_inventory') }}</h3>
                        <section>
                            <div id="single-details">
                                <div class="form-group mb-4">
                                    <label for="total_quatity">{{ __('messages.total_quatity') }} *</label>
                                    <input required type="number" name="total_quatity" class="form-control" id="total_quatity" placeholder="{{ __('messages.total_quatity') }}" value="{{ old('total_quatity') }}" >
                                </div>
                                <div class="form-group mb-4">
                                    <label for="remaining_quantity">{{ __('messages.remaining_quantity') }} *</label>
                                    <input required type="number" name="remaining_quantity" class="form-control" id="remaining_quantity" placeholder="{{ __('messages.remaining_quantity') }}" value="{{ old('remaining_quantity') }}" >
                                </div>
                                <div class="form-group mb-4">
                                    <label for="price_before_offer">{{ __('messages.product_price') }} *</label>
                                    <input required type="number" step="any" min="0" name="price_before_offer" class="form-control" id="price_before_offer" placeholder="{{ __('messages.product_price') }}" value="{{ old('price_before_offer') }}" >
                                </div>
                                <div class="form-group mb-4">
                                    <label for="stored_number">{{ __('messages.product_stored_number') }}</label>
                                    <input type="text" name="stored_number" class="form-control" id="stored_number" placeholder="{{ __('messages.product_stored_number') }}" value="" >
                                </div>
                                <div class="form-group mb-4">
                                    <label for="barcode">{{ __('messages.barcode') }}</label>
                                    <input type="text" name="barcode" class="form-control" id="barcode" placeholder="{{ __('messages.barcode') }}" >
                                </div>
                            </div>
                            <div style="margin-bottom: 20px; margin-top : 20px" class="col-md-3" >
                                <div >
                                   <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                     <input id="discount" name="offer" value="1" type="checkbox" class="new-control-input">
                                     <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.discount') }}</span>
                                   </label>
                               </div>     
                            </div>
                            <div style="display:none" class="form-group mb-4">
                                <label for="offer_percentage">{{ __('messages.discount_value') }} ( % )</label>
                                <input disabled type="number" step="any" min="0" name="offer_percentage" class="form-control" id="offer_percentage" placeholder="{{ __('messages.discount_value') }}" value="" >
                            </div>
                            <div id="single-discount">
                                <div style="display:none" class="form-group mb-4">
                                    <label for="final_price">{{ __('messages.price_after_discount') }}</label>
                                    <input style="font-size: 15px" disabled type="number" step="any" min="0" name="final_price" class="form-control" id="final_price" placeholder="{{ __('messages.price_after_discount') }}" value="" >
                                </div>
                            </div>


                            <div style="margin-bottom: 20px; margin-top : 20px" class="col-md-3" >
                                <div class="" >
                                    <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                    <input name="global_shipping" value="1" type="checkbox" class="new-control-input">
                                    <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.global_shipping') }}</span>
                                    </label>
                                </div> 
                            </div>
                            
                        </section>
                    </div>
        
                </div>
            </div>
            
            {{-- <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary"> --}}
        </form>
    </div>
@endsection