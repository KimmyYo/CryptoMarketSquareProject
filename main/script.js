// windows ready section
$(document).ready(function(){
    stickNavbar();
    getCurrentURL();
    dashboard_sidmenu();
    loaddata();


    // plus_amount();
    // minus_amount();
    click_func($("#user_arrow"), $("#leaving_box"));
    click_func($(".edit_button"), $(".edit_section"));
    click_func($(".x"), $("#edit_place"));
    click_func($("#close_toast"), $("#toast_block"));
    click_func($("#show_more"), $("#description"));
    click_func($("#question_x"), $("#delete_area"));
    click_func($("#product_btn"), $("#product_section"));
    click_func($(".set_hashtag"), $(".stage"));
    click_func($(".close_stage"), $(".stage"));
    
    
});

var trending_up_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trending-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 17l6 -6l4 4l8 -8"></path><path d="M14 7l7 0l0 7"></path></svg>';
var trending_down_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trending-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"<path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7l6 6l4 -4l8 8"></path><path d="M21 10l0 7l-7 0"></path></svg>';
function trending_display(trend, parent_div, arrow){
    console.log(trend, parent_div, arrow);
    if(trend == "up"){
        $("#" + parent_div).css('color', '#1f8c1b');
        $("#" + arrow).html(trending_up_svg);
        
       
    }  
    else if (trend == "down"){
        $("#" + parent_div).css('color', '#ba221a');
        $("#" + arrow).html(trending_down_svg);

    } 
   
}

function plus_amount(){ // add product++ to chart
    console.log("plus");
    var amount_input = $('#amount_input');
    amount_input.val(parseInt(amount_input.val()) + 1);
    amount_input.change();
    return false;
       
  
}
function minus_amount(){
    
    console.log("minus");
    var amount_input = $('#amount_input');
    var count = parseInt(amount_input.val()) - 1;
    console.log(count);
    count = count < 1 ? 1 : count;
    amount_input.val(count);
    amount_input.change();
    return false;
    
   

}
var loadFile = function(event) {
    var new_image_tag = '<img id="output" src="#"/>';
    $("#to_put_image").empty();
    $("#to_put_image").html(new_image_tag);
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    console.log(output.src);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        
        $("#output").show();
    }
};

function stickNavbar() {
    
    $(window).on('scroll', function(){
         // init navbar, scroll
        var navbar = $(".main_header");
        var logo = $(".logo");
        var scroll = $(window).scrollTop();
        
        var navbarHeight = navbar.height();
        var mincount = 10;
        var maxcount = 20

        // when scroll over certain height
        if($(window).width()){
            if(scroll > navbarHeight + 50){
                // change right header to sticky navbar
                navbar.addClass("sticky");
            } else {
                navbar.removeClass("sticky");
            }
        }
        
    // adjust logo size also 
    });



   
}

function click_func($be_clicked,$to_show){
    $be_clicked.click(function(){
        
        console.log("clicked");
        $to_show.toggle();
        
    });
}
function dashboard_sidmenu() {
    const sideMenu = $('#side-menu');
    const dashboard = $('#dashboard');
    
    if (!sideMenu.length) {
        console.log("this ");
    }
  
    sideMenu.on('click', (event) => {
      // Get the id of the widget to show
      const widgetId = $(event.target).data('id');
  
      // Find the placeholder element in the widget
      const widgetContent = $(`#${widgetId}-content`);
  
      // Make an AJAX request to the PHP script
      $.ajax({
        url: `board_content.php?id=${widgetId}`,
        method: 'GET',
        success: (response) => {
          // Update the content of the placeholder element with the response from the PHP script
          widgetContent.html(response);
  
          // Show the widget by setting its display style to "block"
          const widget = $(`#${widgetId}`);
          widget.css('display', 'block');
  
          // Hide all other widgets in the dashboard
          const otherWidgets = $('.dashboard-widget:not(#' + widgetId + ')');
          otherWidgets.css('display', 'none');
        },
        error: (xhr) => {
          console.log(`Error: ${xhr.statusText}`);
        }
      });
    });
}
// const dashboardDefault = $("#dashboard_default");
// if(dashboardDefault.length){
//     dashboardDefault.css("display", "block");
//     const otherWidegets = $('.dashboard-widget:not(#default-section)');
//     otherWidegets.css("display", "none");
// }

  

function get_upload(event){
    
    event.preventDefault();
    // get every innerhtml of tags
    var tagList = $("#tagList");
    var tagsAll = "";
    tagList.children('li').each(function() {
        var tag = $(this).html();
        
        tag = "#" + tag.split("<")[0];
        tagsAll += tag;
        console.log(tagsAll);
        
    });
    $("#all_tags").val(tagsAll);
    console.log($("#upload_form")[0]);
    submitForm($("#upload_form")[0], "upload");
}

function get_edit(pNo, action){
    
    // section to show for edit and delete
    var edit_section = $("#edit_area");
    var delete_section = $("#delete_area");

    var xhr = new XMLHttpRequest();
    if(action == "edit"){ // if the product edit button is clicked
        xhr.open("GET", "edit_product.php?pNo=" + pNo, true);

        xhr.onload = function() { 
            // show the edit form content first 
            console.log("edit button clicked");
            edit_section.toggle();
            edit_section.html(xhr.responseText); 
    
            var edit_submit = $("#edit_submit");
            // when submit button is clicked -> execute submit form 
            edit_submit.on('click', function(event) {
                console.log("submit clicked");
                event.preventDefault();
                submitForm($("#edit_form")[0], "edit");
            })
        };
    } else if (action == "delete"){
        
        xhr.open("GET", "delete_product.php?pNo=" + pNo, true);
        
        xhr.onload = function() { 
            delete_section.toggle();
            delete_section.html(xhr.responseText);
            console.log("deleted button clicked");
    
            var delete_submit = $("#delete_submit");
            delete_submit.on('click', function(event) {
                console.log("delete clicked");
                event.preventDefault();
                submitForm($("#delete_form")[0], "delete");
            })
        };
    }
   
    xhr.send();
}

function submitForm(get_el, action){
    var formData = new FormData(get_el);
    console.log(formData);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if (xhr.status === 200) {
                if (xhr.responseText.includes("publickey")) {
                    alert("Please add your public key of your store from profile");
                }
                else {
                    alert ("SUCCESSFULLY" + action);
                }
                // Display the response from the server
                console.log(xhr.responseText);
            } else {
                console.log("Error: " + xhr.status);
            }
        }
    };
    
    xhr.open("POST", action + "_product.php");
    xhr.send(formData);
    alert("SUCCESSFULLY  " + action);
    var widgetId = 0;
    if (action == "edit"){
        $("#edit_area").toggle();
        widgetId = 3;
    } else if (action == "delete"){
        console.log("right");
        $("#delete_area").toggle();
        widgetId = 3;
    } else if (action == "upload"){
        widgetId = 3;
    }
    
    $(document).ready(function() {
        // Reload the page
        // location.reload();
        console.log("reloaded");
      
        // Make an AJAX request to fetch the new content
        $.ajax({
          url: 'board_content.php?id='+widgetId,
          type: 'GET',
          dataType: 'html',
          success: function(response) {
            // Insert the new content into the DOM
            $('#dashboard-widget-'+widgetId+'-content').html(response);
          }
        });
    });

};
function getCurrentURL () {
    
    var current_url = window.location.href;

    if(current_url.includes("http://localhost/CryptoMarketSquare/")){
        $(".crumb").html("Crypto Market Square");
    } 
    if (current_url.includes("http://localhost/CryptoMarketSquare/dashboard.php")){
        $(".crumb").html("Dashboard");
        $(".input-box").css('display', 'none');
    }
    
}
function filter_products(){
    var find_pName = $("#find_pName").val();
    var find_category = $("#find_category").val();
    var find_hashtag = $("#find_hashtag").val();
    // console.log(find_pName, find_category);
    $('#filter_form').submit(function(e){
        e.preventDefault(); // prevent the form from submitting normally
        var formData = $(this).serialize(); // serialize the form data
        $.ajax({
          url: 'filter.php?pName=' + find_pName + "&category=" + find_category + "&hashtag=" + find_hashtag, // the URL where the form data will be submitted
          type: 'GET', // the method used for submitting the form data
          data: 'html', // the form data
          success: function(response){
            // console.log(response);
            $(".product_table").html(response);
           
          }
        });
      });
}
function add_heart(pNo){
    console.log("TT"+heart);
    var current_likes = $(".heart_num").html();
    console.log(current_likes);
    $.ajax({
        url: 'product_likes.php', // the URL where the form data will be submitted
        type: 'POST', // the method used for submitting the form data
        data: { likes: current_likes, pNo: pNo}, // the form data
        success: function(response){
            console.log(response);
            $(".heart_num").html(response);
            // $("#heart_hole").toggle();
            // $("#heart_fill").toggle();
        }
    });
    if (heart == 1) {
        $('#heart_hole').attr("fill","none");
        heart = 0;
    }
    else {
        $('#heart_hole').attr("fill","rgb(180, 50, 50)");
        heart=1;
    }
}

function get_category(obj, cate_name){
    var products_section = $(".products_section");
   
    var right_arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>';
    $.ajax({
        url: 'get_category.php?category=' + cate_name,
        type: 'GET',
        dataType: 'html',
        success: function(response){
            products_section.empty();
            products_section.html(response);
            $(".crumb").html("<a id='crumb_link' href='index.php'>Home</a>  " + right_arrow_svg + "   " 
            + cate_name);
            
            
        }
    })
}

// ---- ---- Const ---- ---- //
let inputBox = document.querySelector('.input-box'),
searchIcon = document.querySelector('.search'),
closeIcon = document.querySelector('.close-icon');
console.log(inputBox, searchIcon, closeIcon);
// ---- ---- Open Input ---- ---- //

// searchIcon.on('click', () => {
//   inputBox.classList.add('open');
// });
// ---- ---- Close Input ---(- ---- //
// function close_search(this){
//     $(".input-box").removeClass('open');
// }
// closeIcon.on('click', () => {
//   inputBox.classList.remove('open');
// });




function get_hashtag(){
    

    $('#pair_out').submit(function(event) {
         // Prevent the form from submitting normally
        
        var tags_content = $("#tags").val(); // Serialize form data
        event.preventDefault();
        console.log(tags_content);
        $.ajax({
            url: 'pair_out.php',
            type: 'POST',
            data: {input_tag: tags_content},
            success: function(response) {
                // Handle success response
                $(".products_section").empty();
                $(".products_section").html(response);
                $(".stage").hide();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(error);
            }
        });
       
    });
    
}

function tagError(){
    alert("Tag is in wrong format. Add whatever logic is needed here, whether toggling of a field validation element, or an alert, etc.");
}


function generateHiddenInput(){
    var tags = "";
    var tagCount = 0, tagMax = 10; //MODIFY MAX COUNT TO YOUR LIKING
    $("#tagList li").each(function(i){
      tags += $(this).attr("data-htag") + " ";
      tagCount++;
    });
    $("#tags").val(tags.trim());
    console.log("Current val of tags is '" + $("#tags").val() + "'");
    return tagCount <= tagMax;
}

function addToHashtagList(tag){
    var cute_x = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-6.489 5.8a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path></svg>';

    $("#tagList").append("<li data-htag='" + tag + "'>" + tag + "<a  onclick='remove_tag(this)' title='Remove Tag'>" + cute_x+ "</a></li>");
    if (!generateHiddenInput()){
      alert("Too many. Add whatever logic is needed here, whether toggling of a field validation element, or an alert, etc.");
      $("#tagList").children().last().remove();
      generateHiddenInput();
    }
}

function upload_hashtag(){
    var rgxHashtag = /^#?([a-zA-Z\d]{3,12})$/;
    var inString = $("#tagInput").val().trim();
    if(!rgxHashtag.test(inString)){
      tagError();
      return;
    }
    var tagToAdd = rgxHashtag.exec(inString)[1];
    if($("#tagList li[data-htag='" + tagToAdd + "']").length > 0){
      return false; //Tag already existed.
    }
    addToHashtagList(tagToAdd);
    $("#tagInput").val("");
    return false;
}

function remove_tag(e){
    $(e).parent().remove();
}

function fave_delete(obj, pNo, userid){
    
    $.ajax({
        url: 'fave_delete.php?pNo=' + pNo + "&mId=" + userid,
        type: 'GET',
        dataType: 'html',
        success: function(response){
            console.log(response);
            $(obj).parent().parent().fadeOut(300);
           
        }
    })
}

// AJAX
var post=0;
function loaddata () {
    
    if (post < limit) {
        $('#product_loading').css("display", "block");
        $.ajax({
            url: "index-ajax.php",
            method: "GET",
            data: {id: post},
            success: function (data) {
                $(".products_section").append(data);
                $('#product_loading').css("display", "none");
                if (post+15 > limit) {
                    $(".reach_bottom").css("display", "none");
                    $(".reach_bottom").css("display", "block");
                }
            }
        });
        post+=15;
    }
}

// 商品AJAX
$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $('body').prop("scrollHeight");
    var clientHeight = document.documentElement.clientHeight;


    if (scrollTop + clientHeight >= scrollHeight - 5) {
        if (post <= limit) {
            loaddata();
        }
    }
})