

<!-- if something wring. i put some variable out of condition fix that -->
<div id="preview_body">




    <div
    class="printHeight"
        style="

        width:75% !important;
        display:block;
        padding:auto auto;
        margin:auto auto;
         padding: 2rem 0 !important;

        " class="sticker-border text-center"

    >

    <div
        style="
        display:block;
        padding:auto auto;
        margin:auto auto;
        text-align:center


        "
    >

<h2> Token number: {{$entry->token}}  </h2>
<h2> Car number: {{$entry->car_number}}  </h2>
<h2> In time: {{$entry->created_at}}  </h2>


{{--
In time
            <h2>Welcome</h2>
            <h2>Your token is : {{$entry->token}}</h2> --}}














</div>
    </div>









</div>

<style type="text/css">

@media print{
       #preview_body{
        display: block !important;
    }
     body {
margin-top: -2rem !important;

}


}

/*@page {*/
/*	size: 2.00 in 1.50in ;*/
/*	margin-top: 0in;*/
/*	margin-bottom: 0in;*/
/*	margin-left: 0in;*/
/*	margin-right: 0in;*/


/*}*/

</style>
