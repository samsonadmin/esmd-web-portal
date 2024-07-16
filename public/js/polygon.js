//https://stackoverflow.com/questions/59287928/algorithm-to-create-a-polygon-from-points 

function squaredPolar(point, centre) {
    return [
        Math.atan2(point[1]-centre[1], point[0]-centre[0]),
        (point[0]-centre[0])**2 + (point[1]-centre[1])**2 // Square of distance
    ];
}

// Main algorithm:
function polySort(points) {
    // Get "centre of mass"
    let centre = [points.reduce((sum, p) => sum + p[0], 0) / points.length,
                  points.reduce((sum, p) => sum + p[1], 0) / points.length];

    // Sort by polar angle and distance, centered at this centre of mass.
    for (let point of points) point.push(...squaredPolar(point, centre));
    points.sort((a,b) => a[2] - b[2] || a[3] - b[3]);
    // Throw away the temporary polar coordinates
    for (let point of points) point.length -= 2; 
}


let all_points = []; //Storing all the points 
let selected_tab = "restricted";
//points are the points, displayed currently
let points = []; 

// I/O management

let canvas = document.querySelector("canvas");
let ctx = canvas.getContext("2d");

var draging = false;


const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
const serial_no = urlParams.get('serial_no');



let zone_color = []
// zone_color[ 'lifting'] = ["#D9F0FF70", "#ADD5FF", "#83C9F4"];
// zone_color[ 'danger'] = ["#FFAF8770", "#FF8B72", "#ED6A5E"];
// zone_color[ 'restricted' ] = ["#F8F7FF70", "#B8B8FF", "#9381FF"];


function draw(points) {

    let color1 = "#FF5733";
    let color2 = "#335EFF";
    let color3 = "rgba(133, 193, 233, 0.3)";

    if ( typeof zone_color[selected_tab] !== 'undefined' )
    {
        color1 = zone_color[selected_tab][2];
        color2 = zone_color[selected_tab][1];
        color3 = zone_color[selected_tab][0];
    }

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!points.length) return;
    for (let [x, y] of points) {
        ctx.beginPath();
        ctx.arc(x, y, 3, 0, 2 * Math.PI, true);
        ctx.fillStyle = color1;
        ctx.fill();
    }
    ctx.beginPath();
    ctx.moveTo(...points[0]);
    for (let [x, y] of points.slice(1)) ctx.lineTo(x, y);
    ctx.closePath();
    ctx.strokeStyle = color2;
    ctx.stroke();
    ctx.fillStyle = color3;
    ctx.fill();
}


function onMouseDrag(match_index, this_obj, evt)
{                    

    if (draging)
    {
        // console.log("onMouseMove")
        let x = evt.clientX - this_obj.offsetLeft;
        let y = evt.clientY - this_obj.offsetTop;                    
        
        if (match_index >= 0)
            points[match_index] = [x, y]

        //console.log(points[match_index])

        //points.splice(match, 1);
        //points.push([x, y]);
        
        
    }
    //console.log( points.length)
    draw(points);   
    
}

function changeCursor(e)
{
    let x = e.clientX - this.offsetLeft;
    let y = e.clientY - this.offsetTop;                    
    let match = points.findIndex(([x0, y0]) => Math.abs(x0-x) + Math.abs(y0-y) <= 6);
    if (match >= 0)    
    {
        document.body.style.cursor = 'crosshair';
    }else
    {
        document.body.style.cursor = 'default';
    }
}

function detect_tab_selection()
{

    $('.zone_btn').each( function (index)
    {

        //console.log(zone_color[$(this).data("tab")][2]);

        if ( typeof zone_color[$(this).data("tab")] !== 'undefined' )
        {
            $( this ).css( "color", zone_color[$(this).data("tab")][2] );
        }

        if ( selected_tab != $(this).data("tab") )
        {
            $( this ).removeClass( "active" );
        }
        else
        {
            $( this ).addClass( "active" );
        }
    });

}

function get_relative_position()
{
    let relative_points = [];
    let width = canvas.width;
    let height = canvas.height;
    for (i=0; i<points.length; i++)
    {
        relative_points.push( [ points[i][0]/width , points[i][1]/height ] );
    }
    return relative_points;
}

/**
 * https://www.algorithms-and-technologies.com/point_in_polygon/javascript
 * * https://assemblysys.com/php-point-in-polygon-algorithm/#:~:text=The%20point%2Din%2Dpolygon%20algorithm,intersects%20with%20the%20polygon%20boundary.
 * 
 * Performs the even-odd-rule Algorithm (a raycasting algorithm) to find out whether a point is in a given polygon.
 * This runs in O(n) where n is the number of edges of the polygon.
 *
 * @param {Array} polygon an array representation of the polygon where polygon[i][0] is the x Value of the i-th point and polygon[i][1] is the y Value.
 * @param {Array} point   an array representation of the point where point[0] is its x Value and point[1] is its y Value
 * @return {boolean} whether the point is in the polygon (not on the edge, just turn < into <= and > into >= for that)
 */
var pointInPolygon = function (polygon, point) {
    //A point is in a polygon if a line from the point to infinity crosses the polygon an odd number of times
    let odd = false;
    //For each edge (In this case for each point of the polygon and the previous one)
    for (let i = 0, j = polygon.length - 1; i < polygon.length; i++) {
        //If a line from the point into infinity crosses this edge
        if (((polygon[i][1] > point[1]) !== (polygon[j][1] > point[1])) // One point needs to be above, one below our y coordinate
            // ...and the edge doesn't cross our Y corrdinate before our x coordinate (but between our x coordinate and infinity)
            && (point[0] < ((polygon[j][0] - polygon[i][0]) * (point[1] - polygon[i][1]) / (polygon[j][1] - polygon[i][1]) + polygon[i][0]))) {
            // Invert odd
            odd = !odd;
        }
        j = i;

    }
    //If the number of crossings was odd, the point is in the polygon
    return odd;
};


 

function get_zone_ajax()
{
	$.ajax({
        url: "load_save_zones_ajax.php",
        data: { serial_no: serial_no},				
		type: "GET",
        dataType: 'json',
				success: function (response) {
                    let jsonObj = response;

                    for (let i = 0; i < jsonObj.length; i++) {
                        const obj = jsonObj[i];
                        //console.log(`Serial No: (THIS:${serial_no}) ${obj.serial_no}`);

                        if (obj.serial_no === serial_no)
                        {
                            //console.log ("Matching this serial No")

                            $('#zone_name_buttons').html("");
                            // Create a new button element                     

                            for (let j = 0; j < obj.zones.length; j++) {
                                const zone = obj.zones[j];
                                //console.log(`Zone Name: ${zone.name}`);
                                //console.log(`Points: ${zone.points}`);

                                //This part creates the buttons
                                const $button = $("<button>");

                                // Set the class and data attributes
                                $button.addClass("btn btn-light zone_btn");
                                $button.attr("data-tab", zone.name ); 

                                if ( typeof zone_color[zone.name] !== "undefined"  )
                                $button.css( "color", zone_color[ zone.name][2] );

                                $button.html( zone.name);    
                                                            
                                $("#zone_name_buttons").append($button);
                                //Ends creating the buttons,

                                let temp_points = []

                                // This part parses the relative points into points
                                for (let [x, y] of zone.points) {
                                    temp_points.push(  [x * canvas.width, y * canvas.height] );
                         
                                }

                                
                                all_points[zone.name]=temp_points

                                //Only draw the 1st loaded points
                                if (j==0)
                                {                                
                                    selected_tab = zone.name;
                                    points = temp_points
                                    
                                    draw(points)

                                    $( "#status_text" ).html("Loaded: " + selected_tab);
                                    $( "#status_text" ).fadeTo( "fast" , 1, function()
                                    {
                                        $( "#status_text" ).fadeTo( 2000 , 0 );
                                    });  

                                    detect_tab_selection();
                                }

                            }


                            // Listen for hash changes
                            if (window.location.hash) {
                                //console.log("Hash loaded:", window.location.hash);

                                zone_name = window.location.hash.replace("#", "").toLowerCase() ;
                                //console.log(zone_name);

                                $("#zone_name_buttons button").each( 
                                    function(i){
                                        if ( $(this).data("tab").toLowerCase() == zone_name )
                                        {

                                            $(this).click();
                                        }
                                    }
                                );

                            };

                        }
                        else
                        {
                            //console.log ("NOT Matching this serial No")
                        }


                      }



				},
				error: function (xhr, status) {
					// handle errors         
                    console.log(status);

				},
				dataType: "json",
				timeout: 6000 // sets timeout to 6 seconds
			});        
        
}



function save_zone_ajax(post_data)
{
	$.ajax({
        url: "load_save_zones_ajax.php",
        data: post_data,				
		type: "POST",
        dataType: 'json',
				success: function (response) {
                    // Handle the successful response here
                    console.log(response);
                    //alert("success " + response)
                    if (typeof response.error != 'undefined'){
                        alert(response.error);
                    }
                    else
                    {
                        // Reload the current page
                        //location.reload();
                        console.log("SAVE SUCCESS!")
                    }
				},
				error: function (xhr, status) {
					// handle errors         
                    console.log(status);

				},
				dataType: "json",
				timeout: 6000 // sets timeout to 6 seconds
			});        
        
}




$(document).ready(function() {

    //get_latest_image();
    get_zone_ajax();

    let onMouseDragHandler;


    canvas.addEventListener('contextmenu', function(e) { // Right click
        e.preventDefault()

        let x = e.clientX - this.offsetLeft;
        let y = e.clientY - this.offsetTop;                    
        let match = points.findIndex(([x0, y0]) => Math.abs(x0-x) + Math.abs(y0-y) <= 6);        
        if (match >= 0)
        {
            points.splice(match, 1);
            //points.push([x, y]);
        }
        else{
            let result = pointInPolygon(points, [x,y] )
            console.log(result);
        }

        //points.pop(); // delete the last clicked point
        polySort(points);
        draw(points);        
        //console.log("contextmenu");
    });

    canvas.addEventListener('mousemove', changeCursor );                



    canvas.addEventListener('mousedown', function (e) {
        //left click
        dragok = true;
        //console.log("mousedown");


        let x = e.clientX - this.offsetLeft;
        let y = e.clientY - this.offsetTop;

        let match = points.findIndex(([x0, y0]) => Math.abs(x0-x) + Math.abs(y0-y) <= 6);
        //console.log(match)

        canvas.addEventListener('mouseup', function (e)
        {
            //console.log("onmouseup");
            draging = false;
            canvas.removeEventListener('mousemove', onMouseDragHandler);
            canvas.onmouseup = null;            
            polySort(points);
            draw(points);               
            
            
        });

        draging = true;

        onMouseDragHandler = function(evt) {            
            onMouseDrag(match, this, evt)
        }              
         

        canvas.addEventListener('mousemove', onMouseDragHandler);            
    

        //console.log(x,y);

        
        
    });


    canvas.addEventListener('click', function (e) {

        //left click
        if ( e.button === 0 )
        {
            let x = e.clientX - this.offsetLeft;
            let y = e.clientY - this.offsetTop;
            let match = points.findIndex(([x0, y0]) => Math.abs(x0-x) + Math.abs(y0-y) <= 6);
            if (match < 0) points.push([x, y]);

//            else points.splice(match, 1); // delete point when user clicks near it.
            polySort(points);
            draw(points);
            //console.log(x,y);
        }


        // //right click
        // else if ( e.button === 2)
        // {
        //     points.pop(); // delete the last clicked point
        //     draw(points);
        // }
    });

    //detect_tab_selection();

    //below are for the buttons
    $(document.body).on('click', '.zone_btn', function() 
    {
   
        if (all_points [ $(this).data("tab") ] === 'undefined')
            points = []
        else
            points = all_points [ $(this).data("tab") ];
        //all_points [ $(this).data("tab") ] = points;
        //console.log(  $(this).data("tab") );
        selected_tab = $(this).data("tab");
        $("#delete-zone-name").html(selected_tab);
        $('#delete-btn').prop("disabled", false);

        $( "#status_text" ).html("Loaded: " + $(this).data("tab"));
            $( "#status_text" ).fadeTo( "fast" , 1, function()
            {
                $( "#status_text" ).fadeTo( 2000 , 0 );
            });         
        detect_tab_selection();
        //console.log(points)
        draw(points);
        
    });

    // $('#delete-btn').on('click', function() 
    // {  
    //     points = [];
    //     all_points [ selected_tab ] = points;
    //     draw(points);
    // });

    //Save Zone button
    $('#save').on('click', function() 
    {   
        if ( points.length > 0)
        {
            all_points [ selected_tab ] = points;
            $( "#status_text" ).html("saved!");
            $( "#status_text" ).fadeTo( "fast" , 1, function()
            {
                $( "#status_text" ).fadeTo( 1000 , 0 );
            });            
        }
        else
        {
            $( "#status_text" ).html("Empty Zone, zone deleted");
            $( "#status_text" ).fadeTo( "fast" , 1, function()
            {
                $( "#status_text" ).fadeTo( 1000 , 0 );
            });
        }

        let relative_positions = get_relative_position();
        //console.log(relative_positions);

        let zone_name = selected_tab;

        let post_data = {
            serial_no : serial_no,
            zone_name : zone_name,
            zone_color : '',
            points : relative_positions
        };

        save_zone_ajax(post_data);        

    });

    // Handle the save button click event

    //Remove space and non characters for zone name
    $('#zone-name').on('blur', function()
    {
        $('#zone-name').val( $('#zone-name').val().toLowerCase().replace(/[^a-zA-Z_]+/g, '') );
    });

    //New Zone Modal save button
    $('#save-button').click(function(){
        // Get the zone name and color values
        let zone_name = $('#zone-name').val();
        let zone_color = $('#color-picker').val();

        // Do something with the zone name and color values
        console.log("Zone Name: " + zone_name);
        console.log("Zone Color: " + zone_color);

        // Close the modal
        $('#new_zone_modal').modal('hide');

        $('#zone-name').val("");

        let post_data = {
            serial_no : serial_no,
            zone_name : zone_name,
            zone_color : zone_color
        };

        save_zone_ajax(post_data);
        $( "#status_text" ).html("Created: " + selected_tab);
            $( "#status_text" ).fadeTo( "fast" , 1, function()
            {
                $( "#status_text" ).fadeTo( 2000 , 0 );
                // Reload the current page
                window.location.hash = "#" + zone_name;
                location.reload();
            });  
            
    });    


    // Add a click event listener to the confirm delete button
    $("#confirm-delete-button").click(function() {
        // TODO: Add your delete logic here
        let zone_name = selected_tab;

        let post_data = {
            serial_no : serial_no,
            zone_name : zone_name,
            zone_color : '', //Do not delete this line
            action : "delete"
        };

        save_zone_ajax(post_data);      

        
        // Close the modal
        $('#delete_modal').modal('hide');
        $( "#status_text" ).html("DELETE: " + selected_tab);
            $( "#status_text" ).fadeTo( "fast" , 1, function()
            {
                $( "#status_text" ).fadeTo( 2000 , 0 );
                // Reload the current page
                location.reload();
            });         

    });

    //


} );    
