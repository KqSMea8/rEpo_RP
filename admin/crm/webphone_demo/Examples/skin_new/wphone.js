// Webphone public API
// 
// You can control the webphone using the below API functions
// Description can be found near every API function

var wphone = (function ()
{

// Configuration settings can be specified below:
var parameters = {
                    // example: 
                         // upperserver: ''     /*Your VoIP server IP address*/
                 };


// call this function once and pass a callback, to receive status messages
//Ex: wphone.getStatus( function (status) { alert('status: ' + status); } );
function getStatus (callback)
{
    if ( !callback || typeof (callback) !== 'function' ) { return; }

    stcb = callback;
}

// call this function once and pass a callback, to receive event messages
//Ex: wphone.getEvents( function (event) { alert('event: ' + event); } );
function getEvents (callback)
{
    if ( !callback || typeof (callback) !== 'function' ) { return; }

    evcb = callback;
}

// call this function once and pass a callback, to receive notifications
//Ex: wphone.getNotification( function (notification) { alert('notification: ' + notification); } );
function getNotification (callback)
{
    if ( !callback || typeof (callback) !== 'function' ) { return; }

    ntcb = callback;
}

// start the phone (register to your voip server)
// any additional parameters must be set before calling start(). Use setparameter(param, value) function for this.
function start (username, password) // boolean
{
    return plhandler.Start(username, password, parameters);
}

// Initiate call to a number or sip username.
function call (line, number, name) // boolean
{
    return plhandler.Call(line, number, name);
}

//Disconnect current call(s). If you set -2 for the line parameter, then all calls will be disconnected (in case if there are multiple calls in progress)
function hangup (line) // boolean
{
    return plhandler.Hangup(line);
}

// Connect incoming call.
function accept (line) // boolean
{
    return plhandler.Accept(line);
}

// Disconnect incoming call.
function reject (line) // boolean
{
    return plhandler.Reject(line);
}

// Add people to conference.
// If peer is empty than will mix the currently running calls (if there is more than one call)
// Otherwise it will call the new peer (usually a phone number or a SIP user name) and once connected will join with the current session.
function conference (line, number) // boolean
{
    return plhandler.Conference(line, number);
}

// Transfer current call to peer which is usually a phone number or a SIP username. (Will use the REFER method after SIP standards).
// You can set the mode of the transfer with the “transfertype” applet parameter.
function transfer (line, number) // boolean
{
    return plhandler.Transfer(line, number);
}

// Send DTMF message by SIP INFO or RFC2833 method (depending on the “dtmfmode” applet parameter).
// Please note that the dtmf parameter is a string. This means that multiple dtmf characters can be passed at once
// and the webphone will streamline them properly. Use the space char to insert delays between the digits.
// The dtmf messages are sent with the protocol specified with the “dtmfmode” applet parameter.
// Example:	API_Dtmf(-2,” 12 345 #”);
function dtmf (line, char) // boolean
{
    return plhandler.Dtmf(line, char);
}

// Mute current call. The direction can have the following values:
//      0:  mute in and out 
//	1:  mute out (speakers)
//	2: mute in (microphone)
//	3: mute in and out (same as 0)
function mutex (line, mute, direction) // boolean
{
    return plhandler.MuteEx(line, mute, direction);
}

// Hold current call. This will issue an UPDATE or a reINVITE.
// Set the second parameter to true for hold and false to reload.
function hold (line, hold) // boolean
{
    return plhandler.Hold(line, hold);
}

// Send a chat message. (SIP MESSAGE method after RFC 3428)
// Peer can be a phone number or SIP username/extension number.
function sendchat (line, number, msg) // boolean
{
    return plhandler.SendChat(line, number, msg);
}

// Open audio device selector dialog (built-in user interface).
function audiodevice()
{
    return plhandler.AudioDevice();
}

// Set volume (0-100%) for the selected device. Default value is 50% -> means no change
// The dev parameter can have the following values:
//  -0 for the recording (microphone) audio device
//  -1 for the playback (speaker) audio device
//  -2 for the ringback (speaker) audio device
function setvolume(dev, volume)
{
    return plhandler.SetVolume(dev, volume);
}

// any additional parameters must be set before start() is called
function setparameter (param, value)  // boolean
{
    return plhandler.SetParameter(param, value);
}

//Return true if the webphone is registered ("connected") to the SIP server.
function isregistered ()
{
    return plhandler.IsRegistered();
}

// specify callfunction buttons displayed on bottom of page, while in call
// possible values (separated by comma): conference,transfer,numpad,mute,hold
function GetAvailableCallfunctions ()
{
    var callfunctions = 'conference,transfer,numpad,mute,hold';

    return callfunctions;
}

// display help popup
function helpwindow ()
{
    return plhandler.HelpWindow();
}

// go to/open Settings page
function settingspage ()
{
    return plhandler.SettingsPage();
}

// go to/open Dial pad page
function dialpage ()
{
    return plhandler.DialPage();
}

// go to/open Message inbox page
function messageinboxpage ()
{
    return plhandler.MessageInboxPage();
}

// go to/open Message page
function messagepage ()
{
    return plhandler.MessagePage();
}

// go to/open Add contact page
function addcontact ()
{
    return plhandler.AddContact();
}

//***************** public API END *********************

















var stcb = null;
var evcb = null;
var ntcb = null;

function RecStat (st) // helper function
{
    if ( !stcb || typeof (stcb) !== 'function' ) { return; }

    stcb(st);
}

function RecEvt (ev) // helper function
{
    if ( !evcb || typeof (evcb) !== 'function' ) { return; }

    evcb(ev);
}

function RecNot (nt) // helper function
{
    if ( !ntcb || typeof (ntcb) !== 'function' ) { return; }

    ntcb(nt);
}

function InsertApplet(apltstr)
{
    plhandler.InsertApplet(apltstr);
}

// called from windows softphone - on Enter key pressed
function enterkeypress()
{
    return plhandler.EnterKeyPress();
}

function bwanswer(answer)
{
    plhandler.bwanswer(answer);
}

function onappexit() // called right before windows softphone exists
{
    plhandler.onappexit();
}

function getlogs() // called from windows softphone; send logs to softphone API_SetLogs(String)
{
    plhandler.getlogs();
}

function delsettings() // delete all stored data (from cookie and localforage): settings, contacts, callhistory, messages
{
    plhandler.delsettings();
}

var treatuserserverinputasupperserver = 'false'; // treat serveraddress_user as upperserver. Used in case of standalone tunnel server

var wphone = {
    treatuserserverinputasupperserver: treatuserserverinputasupperserver,
    getStatus: getStatus,
    getEvents: getEvents,
    getNotification: getNotification,
    start: start,
    call: call,
    hangup: hangup,
    accept: accept,
    reject: reject,
    conference: conference,
    transfer: transfer,
    dtmf: dtmf,
    mutex: mutex,
    hold: hold,
    sendchat: sendchat,
    audiodevice: audiodevice,
    setvolume: setvolume,
    setparameter: setparameter,
    isregistered: isregistered,
    GetAvailableCallfunctions: GetAvailableCallfunctions,
    helpwindow: helpwindow,
    settingspage: settingspage,
    dialpage: dialpage,
    messageinboxpage: messageinboxpage,
    messagepage: messagepage,
    addcontact: addcontact,
    RecStat: RecStat,
    RecEvt: RecEvt,
    RecNot: RecNot,
    InsertApplet: InsertApplet,
    enterkeypress: enterkeypress,
    bwanswer: bwanswer,
    onappexit: onappexit,
    getlogs: getlogs,
    delsettings: delsettings
};
//window.wphone = wphone;
return wphone;
})();

// redirect to old skin in case of IE6 and 7

function IsIeVersion (version) // :boolean  check if it is IE browser version xxx
{
    try{
    if (version === null) { return false; }

    var agent = navigator.userAgent;
    var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
    var matches = agent.match(reg);
    
    if (typeof (matches) !== 'undefined' && matches !== null
            && typeof (matches[0]) !== 'undefined' && matches[0] !== null && matches[0].indexOf(version) >= 0)
    {
        return true;
    }

    } catch(err) { alert ('wphone IsIeVersion: ' + err); }
    return false;
}

if (IsIeVersion(6) || IsIeVersion(7))
{
    window.location.href = "old_skin/wphone.htm";
}

document.write('<script type="text/javascript" src="js/lib/mwpdeploy.js"></script>');
document.write('<script data-main="js/app/main" src="js/lib/require.js"></script>');


/*function poll(events)
{
    if (typeof (events) !== 'undefined' && events !== null
            && (common_public.Trim(events)).indexOf('LOG') === 0)
    {
        common_public.PutToDebugLog(3, events);
    }else
    {
        common_public.PutToDebugLog(1, events);
    }
}*/


function webphonetojs (events) // receive notifications from webphone.jar
{
    try{
    //common_public.PutToDebugLog(2, 'WEBPHONETOJS: ' + events);
    
    
    webphone_public.webphone_started = true;
    webphone_public.pollstatus = false;

    if (typeof (events) !== 'undefined' && events !== null
            && (common_public.Trim(events)).indexOf('LOG') === 0)
    {
        common_public.PutToDebugLog(3, events);
    }else
    {
        common_public.PutToDebugLog(1, events);
    }
    } catch(err) { common_public.PutToDebugLogException(2, 'wphone webphonetojs: ' + err); }
}