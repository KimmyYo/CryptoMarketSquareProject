
<script>

function weekly_data_process(week_data){

    var x_values = [];
    var y_values = [];

    var current_date = timestamp_to_formatted(new Date());
    var days_count = 0;

    let i = 0;
    for(i = 0; i < 7; i++){
        console.log(week_data);
        // if(days_count == 7){
        //         break;
        // }
        if(i > week_data.length - 2){
            console.log(x_values);
            var currentDate = new Date(x_values[0]);
            currentDate.setDate(currentDate.getDate() - 1);
            var yesterday = currentDate.toISOString().split('T')[0];
            
           
            x_values.unshift(yesterday);
            y_values.unshift(0);
        }
        else{
            // 資料筆數達到7天
           
            // 當第一個DATE欄位非今天時，insert到index 0
            if(week_data[i][0] != current_date && i == 0){
                week_data.unshift([current_date, 0]);
            } 
            // 當有一天DATE欄位沒有值時，insert到index i+1
            current_date = new Date(week_data[i][0]);
            prev_date = new Date(week_data[i+1][0]);

            if((current_date.getDate() - prev_date.getDate()) > 1){
                // insertion 
                
                date_to_insert = new Date(current_date - (3600*24*1000));
                
                date_to_insert = timestamp_to_formatted(date_to_insert);
                week_data.splice(i+1, 0, [date_to_insert, 0]);
                console.log("length" + week_data.length);
            } 
            
            // x: date
            x_values.unshift(week_data[i][0]);
            // y: customers nums
            y_values.unshift(week_data[i][1]);

        }
      
        // days_count++;
        
    }

    // if(i < 7){
    //     var get_last_date = new Date(week_data[i-1][0]);
       
    //     for(i = days_count; i < 7; i++){
    //         date_to_insert = new Date(get_last_date + (3600*24*1));
    //         date_to_insert = timestamp_to_formatted(date_to_insert);
            
    //         x_values.unshift(date_to_insert);
    //         y_values.unshift(0);

    //         get_last_date = date_to_insert;

    //     }
    // }
    console.log(week_data);
    return [x_values.slice(0, 8), y_values.slice(0, 8)];
}

function timestamp_to_formatted(date){
    
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');

    var formattedDate = year + '-' + month + '-' + day;
    return formattedDate;
}

function best_tags_process(sold_tags){

    // x: store unique tags
    var x_values = [];
    // y: store numbers or each unique tags
    var y_values = [];


    // count the number of each tags
    for(let i=0; i < sold_tags.length; i++){
       
        var tag_index = $.inArray(sold_tags[i], x_values);
        // if x_values already exist this tag
        if( tag_index >= 0){
            y_values[tag_index] ++;
        }
        else{
            x_values.push(sold_tags[i]);
            y_values.push(1);
        }
    }

    // pick the best 10 
    if(x_values.length > 10){
        return [x_values.slice(0, 10), y_values.slice(0, 10)];
    }
    else{
        return [x_values, y_values];
    }
}


function proportion_process(cate_class){
    var x_labels = [];
    var y_proportions = [];
    
    var total_sold = 0;

    // get the numbers of all category 
    for(let i = 0; i < cate_class.length; i++){
        total_sold += Number(cate_class[i][1]); 
    }
    
    // count the proportions
    for(let i = 0; i < cate_class.length; i++){
        x_labels.push(cate_class[i][0]);
        var prop = Math.round((cate_class[i][1] / total_sold) * 100) / 100;
        y_proportions.push(prop);
    }

    return [x_labels, y_proportions];
    
}
</script>
