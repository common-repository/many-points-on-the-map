var myMap;

// initialize function
function init() {

    myMap = new ymaps.Map( 'mxmpotm_map', {

        center: [centerMapLatDefault, centerMapLngDefault],

        zoom: zoomMapDefault,

        controls: ['zoomControl','rulerControl']        

    } );

    var objectManager = new ymaps.ObjectManager( {

        clusterize: true,

        gridSize: 100,

        clusterDisableClickZoom: false

    } );

    myMap.geoObjects.add( objectManager );

    objectManager.add( points );
}

// return points
function mxmpotm_return_points_search( $, pointValues, arrayPoints ) {

    var pointArray = [];

    var allPoints = false;

    // map
    $.each( arrayPoints, function() {

        var _this = this;

        // if "pointValues" is array
        if( Array.isArray( pointValues ) ){

            // add all points
            if( pointValues.length === 0 ) {

                pointArray.push( _this );

                allPoints = true;

            } else{

                // each ids
                pointValues.map( function( ids ) {                

                    if( _this.id === ids ) {

                        pointArray.push( _this );

                    }                

                } );

            }            

        } else {

            // add all points
            if( pointValues === 0) {

                pointArray.push( this );

                allPoints = true;

            }

            // add one point
            if( this.id === pointValues ) {

                pointArray.push( this );

            } 

        }              

    } );

    setTimeout( function(){

        // update the map
        mxmpotm_update_map( pointArray, allPoints )

    },500 );

}

// update map
function mxmpotm_update_map( searchPoints, allPoints ) {

    myMap.geoObjects.removeAll();

    var centerMapLat = searchPoints[0].geometry.coordinates[0];

    var centerMapLng = searchPoints[0].geometry.coordinates[1];

    var zoom = zoomToPointDefault;

    if( allPoints ) {

        centerMapLat = centerMapLatDefault;
        
        centerMapLng = centerMapLngDefault;

        zoom = zoomMapDefault;

    }

    myMap.setCenter( [centerMapLat, centerMapLng], zoom, {

        checkZoomRange: true

    } );

    var objectManager = new ymaps.ObjectManager( {

        clusterize: true,

        gridSize: 100,

        clusterDisableClickZoom: false

    } );

    myMap.geoObjects.add( objectManager );

    objectManager.add( searchPoints );

}

// create array of areas
function mxmpotm_create_array_of_areas( $, allPoints ) {

    // array for checking the areas
    var arrayAreas = [];

    // array of object whit of points
    var arrayOfObject = [];

    // loop
    $.each( allPoints, function(){

        var idPoint = this.id;

        this.mx_object.areas.map( function( nameArea ){

            var obj = {
                'areaName': nameArea,
                'ids': [idPoint]
            };

            if( $.inArray( nameArea, arrayAreas ) === -1 ) {

                arrayAreas.push( nameArea );

                arrayOfObject.push( obj );

            } else {

                arrayOfObject.map( function( obj ) {

                    if( obj.areaName === nameArea ) {

                        obj.ids.push( idPoint );

                    }                    

                } );

            }

        } );

    } );

    setTimeout( function(){

        // append options into select tag
        mxmpotm_create_search_area_options( $, '#mxmpotm_map_search_area', arrayOfObject );

    },500 );

    return arrayOfObject;

}

// create search area options
function mxmpotm_create_search_area_options( $, idElement, areas ) {

    // sort by alphabet order
    mxmpotm_areas_sortable_array( areas );

    $( idElement ).append( '<option value="all">' + allAreasText + '</option>' );

    areas.map( function( area, index ){

        $( idElement ).append( '<option value="' + index + '">' + area.areaName + '</option>' );

    } );
   
}

    function mxmpotm_areas_sortable_array( areas ) {

        areas.sort(

            function( a, b ){

                if(a.areaName < b.areaName) { return -1; }

                if(a.areaName > b.areaName) { return 1; }

                return 0;

            }

        );

    }

function mxmpotm_select_default_option( $, elementSelect ) {

    $( elementSelect ).find( 'option' ).each( function(){

        $( this ).removeProp("selected");

    } );

}


/**********************************************************
* Calling
*/
// init
window.onload = function() {
    ymaps.ready(function () {

        init();

    });
}    

jQuery( document ).ready( function( $ ) {

    // select filter type
    $( 'input[type=radio][name=mxmpotm_type_filter]' ).on( 'change', function(){

        if( $( this ).val() === 'area' ) {

            $( '.mxmpotm_map_filter_search_area' ).css( 'display', 'block' );

            $( '.mxmpotm_map_filter_search_point' ).css( 'display', 'none' );

        } else {

            $( '.mxmpotm_map_filter_search_area' ).css( 'display', 'none' );

            $( '.mxmpotm_map_filter_search_point' ).css( 'display', 'block' );

        }

        // update map
        mxmpotm_return_points_search( $, [], points );

        // select default option
        mxmpotm_select_default_option( $, '#mxmpotm_map_search_point' );

        mxmpotm_select_default_option( $, '#mxmpotm_map_search_area' );

    } );

    // search point
    $( '#mxmpotm_map_search_point' ).on( 'change', function(){

        var pointValue = parseInt( $( this ).find( 'option:selected' ).val() );

        mxmpotm_return_points_search( $, pointValue, points );

    } );

    // create select block
    var arrayOfObject = mxmpotm_create_array_of_areas( $, points );

    // search area
    $( '.mxmpotm_map_filter_search_area' ).on( 'change', '#mxmpotm_map_search_area', function(){

        var valueOption = $( this ).find( 'option:selected' ).val();

        var arrayIds = [];

        if( valueOption !== 'all' ) {

            valueOption = parseInt( valueOption );

            arrayIds = arrayOfObject[valueOption].ids;

        }

        // search of areas
        mxmpotm_return_points_search( $, arrayIds, points );

    } );
    

} );

