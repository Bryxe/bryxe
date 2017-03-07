<?php
/**
 * IMPORTANT:
 * This will be included inline using "include" php function where needed
 */
?>
<div class="dialogContentWrapper">
    <div class="dialogContents">
        <div class="dialogTitle">
            <p>No more space to store files</p>
        </div>
        <div class="dialogBody">
            <p>It means that only you cannot add new posts and files to your restricted groups, nor can you add a new
                group.</p>
            <p>So you will continue having access to the private content that you already included. More important, it
                is easy
                to keep adding your own special and private content!</p>
            <div class="dialogBodyRemark">
                <p>To keep your special content fully active click on Activate</p>
            </div>
        </div>

        <div class="dialogButtons">
            <div class="dialogButton" onclick='$( ".msgDialogBox" ).dialog( "close" );return true;'>
                <p style="font-weight: bold"><a style="text-decoration:none;color:white;" target="_new"
                                                href="//google.com">Activate</a></p>
            </div>

            <div class="dialogButton" onclick='$( ".msgDialogBox" ).dialog( "close" );'>
                <p>Close</p>
            </div>

            <div style="clear:both;"></div>
        </div>
    </div>
</div>