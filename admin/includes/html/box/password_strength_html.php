<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
    background-color: #f0f0f0;
    border: 4px solid #000;
    display: none;
    float: right;
    padding-left: 2em;
    position: absolute;
    right: 7px;
    top: 38px;
    width: 25%;
    z-index: 999;
}

.pswd_info_invalid {
    background: transparent url("images/red-x.png") no-repeat scroll left 5px;
    color: #b92025;
}

.passverified{
    background: transparent url("images/success.png") no-repeat scroll left 0px;
    color: #3c763d;
    display: inline-block;
    width: 16px;
    height: 16px;
}
.passnotverified {
    color: #e51f31;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
}

.pswd_info_valid {
    background: transparent url("images/green-check.png") no-repeat scroll left 6px;
    color: #3c763d;
}

.list-unstyled li {
    list-style: outside none none;
    padding-left: 14px;
}
    
</style>
<input type="hidden" id="isvalidate" value="0" />
              <div id="pswd-info-wrap" style="display: none;">
    <div class="arrow_box" id="pswd-info-i">
            <div class="popover-content">
                    <strong>Your password must:</strong>
                    <ul class="list-unstyled">
                            
                            <li id="pswd_info_length" class="pswd_info_invalid">Be 5 to 10 characters long</li>
                            <li id="pswd_info_capital" class="pswd_info_invalid">Have at least one upper case letter</li>
                            <li id="pswd_info_lower" class="pswd_info_invalid">Have at least one lower case letter</li>
                            <li id="pswd_info_number" class="pswd_info_invalid">Have at least one number</li>
                            <li id="pswd_info_symbol" class="pswd_info_invalid">
                                    Have at least one of the following
                                    <br>
                                    &nbsp;&nbsp;<strong>!  &amp; @ ^ $ # % * </strong><br>
                                    &nbsp; no other symbols are allowed<br>
                            </li>
                    </ul>
            </div>
    </div>
</div>
