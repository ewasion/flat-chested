<?php
/**
 * Barebones pomf clone.
 *
 * For anyone wanting to host a pomf clone without going through the boring part.
 */

/* Settings */

/**
 * File system location where to store uploaded files
 *
 * @param string Path to directory with trailing delimiter
 */
define('POMF_FILES_PATH', 'f/');

/**
 * Maximum number of iterations while generating a new filename
 *
 * Pomf uses an algorithm to generate random filenames. Sometimes a file may
 * exist under a randomly generated filename, so we count tries and keep trying.
 * If this value is exceeded, we give up trying to generate a new filename.
 *
 * @param int POMF_FILES_RETRIES Number of attempts to retry
 */
define('POMF_FILES_RETRIES', 15);

/**
 * The length of generated filename (without file extension)
 *
 * @param int POMF_FILES_LENGTH Number of random alphabetical ASCII characters
 * to use
 */
define('POMF_FILES_LENGTH', 6);

/**
 * URI to prepend to links for uploaded files
 *
 * @param string POMF_URL URI with trailing delimiter
 */
define('POMF_URL', (isset($_SERVER['HTTPS'])?"https":"http")."://$_SERVER[HTTP_HOST]".substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1).POMF_FILES_PATH);

/**
 * URI for filename generation
 *
 * @param string characters to be used in generateName()
 */
define('ID_CHARSET', 'abcdefghijklmnopqrstuvwxyz');


/**
 * Filtered mime types
 * @param string[] $FILTER_MIME allowed/blocked mime types
 */
$FILTER_MIME = array();
/**
 * Filter mode: whitelist (true) or blacklist (false)
 * @param bool $FILTER_MODE mime type filter mode
 */
$FILTER_MODE = false;
/**
 * Double dot file extensions
 *
 * Pomf keeps the last file extension for the uploaded file. In other words, an
 * uploaded file with `.tar.gz` extension will be given a random filename which
 * ends in `.gz` unless configured here to ignore discards for `.tar.gz`.
 *
 * @param string[] $doubledots Array of double dot file extensions strings
 * without the first prefixing dot
 */
$doubledots = array_map('strrev', array(
    'tar.gz',
    'tar.bz',
    'tar.bz2',
    'tar.xz',
    'user.js',
));
/**
 * Name for the website
 *
 * @param string Website name
 */
define('POMF_NAME', 'Pantsu');
/**
 * Slogan for the website
 *
 * @param string Website slogan
 */
define('POMF_SLOGAN', 'Kawaii File Hosting!');
/**
 * Email for takedown notices
 *
 * @param string Abuse email
 */
define('POMF_ABUSE_EMAIL', 'abuse@pantsu.cat');
/**
 * Email for questions about the website
 *
 * @param string Info email
 */
define('POMF_INFO_EMAIL', 'info@pantsu.cat');

/* Static */

if(isset($_GET['css'])) {header('Content-Type: text/css');?>.alert,.jumbotron .btn{text-shadow:0 1px rgba(255,255,255,.5)}.progress-outer,img,input[type=image]{vertical-align:middle}*,:after,:before{box-sizing:border-box}body{background-attachment:fixed,fixed;background-color:#F7F7F7;background-image:url(?grill),url(img/bg.png);background-position:85% 100%,top left;background-repeat:no-repeat,repeat;color:#333;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;height:100%;line-height:20px;margin:0;padding-top:20px;padding-bottom:40px}.container{margin:0 auto;max-width:700px}p{margin:0 0 10px}a{color:#0078B4;text-decoration:none;transition:color .25s}a:active,a:focus,a:hover{color:#005580}a:focus{outline:#333 dotted thin}.jumbotron{margin:60px 0;text-align:center;transition:width .5s,height .5s,margin .5s,padding .5s}.jumbotron h1{color:inherit;font-family:inherit;font-size:72px;font-weight:700;line-height:1;margin:10px 0;cursor:default;text-rendering:optimizelegibility}.jumbotron .lead{font-size:21px;font-weight:200;line-height:30px;margin-bottom:20px;transition:font-size .5s}.jumbotron .btn{background:rgba(202,230,190,.75);border:1px solid #B7D1A0;border-radius:4px;color:#468847;cursor:pointer;display:inline-block;font-size:24px;padding:28px 48px;transition:background-color .25s,width .5s,height .5s}.jumbotron .btn.drop,.jumbotron .btn:active,.jumbotron .btn:focus,.jumbotron .btn:hover{background-color:#bce4aa;text-decoration:none}.alert{background-color:#FCF8E3;border:1px solid #FBEED5;border-radius:4px;margin-bottom:20px;padding:8px 14px;transition:width .5s,margin .5s,padding .5s,background-color .5s}.alert-error{background-color:#F2DEDE;border-color:#EED3D7;color:#AA4342}.alert-info{background-color:#D9EDF7;border-color:#BCE8F1;color:#167196}span.donate-btns{display:block;text-align:center;margin:11px 0 3px}a.donate-btn{height:26px;display:inline-block;margin:2px 5px;background:#f2f2f2;line-height:16px;padding:3px 8px 3px 24px;border-radius:3px;color:#3f3f3f;border:1px solid #d8d8d8;transition:all .2s}a.donate-btn:hover{color:#000;border:1px solid #b2b2b2;background-color:#ccc}.icon{display:block;height:16px;width:16px;float:left;margin-left:-20px;margin-top:1px}.icon-paypal{background-image:url(img/paypal.png)}.icon-bitcoin{background-image:url(img/bitcoin.png)}.icon-flattr{background-image:url(img/flattr.png)}nav a,nav>ul{color:#33799B;list-style:none;margin:0;padding:0;text-align:center}nav>ul>li{display:inline-block;margin:0;padding:0;cursor:default}nav>ul>li:after{content:"|";margin:0 8px;opacity:.3}nav>ul>li:last-child:after{content:"";margin:0}#upload-filelist{list-style-type:none;margin:20px 50px;padding:0;text-align:left}.error#upload-filelist{color:#891A18}.error#upload-filelist .progress-percent{color:#B94A48}.error#upload-filelist .file-progress{display:none}#upload-filelist>li{margin-top:5px;overflow:hidden}#upload-filelist>li.total{border-top:1px solid rgba(0,0,0,.05);font-weight:700;padding-top:5px}.file-name{float:left;overflow:hidden;max-width:70%;text-overflow:ellipsis;white-space:nowrap}.file-progress,.file-url{display:inline-block;float:right;font-size:.9em;margin-left:8px;vertical-align:middle}.file-url a{color:#5C5C5C}.file-url a:hover{color:#1C1C1C}.progress-percent{float:right}progress[value]{-webkit-appearance:none;-moz-appearance:none;appearance:none;border:none}progress[value]::-webkit-progress-bar{background-color:#eee;border-radius:2px;box-shadow:0 2px 5px rgba(0,0,0,.25) inset}.completed .file-progress,.completed .progress-percent{display:none}.completed .file-url{display:block}.progress-outer{background-color:rgba(255,255,255,.8);border:1px solid #fff;border-radius:4px;box-shadow:0 0 0 1px #000;color:transparent;display:inline-block;font-size:0;float:right;height:8px;margin:6px 6px 0;overflow:hidden;width:50px}.progress-inner{background-color:#000;height:6px;margin:0;width:0}@media only screen and (max-device-width:320px),only screen and (max-width:400px){body{padding:10px 0 0}.jumbotron{margin:20px 0 30px}.jumbotron .lead{font-size:18px}#upload-filelist,.alert,.jumbotron .btn{border-radius:0;border-width:1px 0;width:100%;margin-left:0;margin-right:0;padding-left:20px;padding-right:20px}#upload-filelist{background-color:rgba(255,255,255,.75);overflow:hidden}#upload-filelist>li.file{margin-top:12px;margin-bottom:12px}.file-progress{width:70%}.file-name,.file-url{width:100%;max-width:100%}.file-url a{text-decoration:underline;margin-left:15px}.file-url a:before{content:"http://"}.alert{font-size:13px}.alert-error{background-color:rgba(248,223,223,.75)}nav{background-color:rgba(255,255,255,.75);border:#FFF;padding:10px 0}}#upload-btn,.js #upload-input,.js input[type=submit]{display:none}.js #upload-btn{display:inline-block!important}<?php
    exit;
}

if(isset($_GET['js'])) {header('Content-Type: application/javascript');?>document.addEventListener("DOMContentLoaded",function(){function addRow(file){var row=document.createElement("li");var name=document.createElement("span");name.textContent=file.name;name.className="file-name";var progressIndicator=document.createElement("span");progressIndicator.className="progress-percent";progressIndicator.textContent="0%";var progressBar=document.createElement("progress");progressBar.className="file-progress";progressBar.setAttribute("max","100");progressBar.setAttribute("value","0");row.appendChild(name);row.appendChild(progressBar);row.appendChild(progressIndicator);document.getElementById("upload-filelist").appendChild(row);return row}function handleUploadProgress(evt){var xhr=evt.target;var bar=xhr.bar;var percentIndicator=xhr.percent;if(evt.lengthComputable){var progressPercent=Math.floor(evt.loaded/evt.total*100);bar.setAttribute("value",progressPercent);percentIndicator.textContent=progressPercent+"%"}}function handleUploadComplete(evt){var xhr=evt.target;var bar=xhr.bar;var row=xhr.row;var percentIndicator=xhr.percent;percentIndicator.style.visibility="hidden";bar.style.visibility="hidden";row.removeChild(bar);row.removeChild(percentIndicator);var respStatus=xhr.status;var url=document.createElement("span");url.className="file-url";row.appendChild(url);var link=document.createElement("a");if(respStatus===200){var response=JSON.parse(xhr.responseText);if(response.success){link.textContent=response.files[0].url.replace(/.*?:\/\//g,"");link.href=response.files[0].url;url.appendChild(link)}else{bar.innerHTML="Error: "+response.description}}else if(respStatus===413){link.textContent="File Too big!";url.appendChild(link)}else{link.textContent="Server error!";url.appendChild(link)}}function uploadFile(file,row){var bar=row.querySelector(".file-progress");var percentIndicator=row.querySelector(".progress-percent");var xhr=new XMLHttpRequest;xhr.open("POST","?upload");xhr["row"]=row;xhr["bar"]=bar;xhr["percent"]=percentIndicator;xhr.upload["bar"]=bar;xhr.upload["percent"]=percentIndicator;xhr.addEventListener("load",handleUploadComplete,false);xhr.upload.onprogress=handleUploadProgress;var form=new FormData;form.append("files[]",file);xhr.send(form)}function stopDefaultEvent(evt){evt.stopPropagation();evt.preventDefault()}function handleDrag(state,element,evt){stopDefaultEvent(evt);if(state.dragCount==1){element.textContent="Drop it here~"}state.dragCount+=1}function handleDragAway(state,element,evt){stopDefaultEvent(evt);state.dragCount-=1;if(state.dragCount==0){element.textContent="Select or drop file(s)"}}function handleDragDrop(state,element,evt){stopDefaultEvent(evt);handleDragAway(state,element,evt);var len=evt.dataTransfer.files.length;for(var i=0;i<len;i++){var file=evt.dataTransfer.files[i];var row=addRow(file);uploadFile(file,row)}}function uploadFiles(evt){var len=evt.target.files.length;for(var i=0;i<len;i++){var file=evt.target.files[i];var row=addRow(file);uploadFile(file,row)}}function selectFiles(target,evt){stopDefaultEvent(evt);target.click()}var state={dragCount:0};var uploadButton=document.getElementById("upload-btn");window.addEventListener("dragenter",handleDrag.bind(this,state,uploadButton),false);window.addEventListener("dragleave",handleDragAway.bind(this,state,uploadButton),false);window.addEventListener("drop",handleDragAway.bind(this,state,uploadButton),false);window.addEventListener("dragover",stopDefaultEvent,false);var uploadInput=document.getElementById("upload-input");uploadInput.addEventListener("change",uploadFiles);uploadButton.addEventListener("click",selectFiles.bind(this,uploadInput));uploadButton.addEventListener("drop",handleDragDrop.bind(this,state,uploadButton),false);document.getElementById("upload-form").classList.add("js")});<?php
    exit;
}

if(isset($_GET['faq'])) {?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta name="generator" content="Pomf &lt;%= pkg.version %&gt;" /><title><?php echo POMF_NAME; ?> &middot; FAQ</title><link rel="icon" href="favicon.ico" /><link rel="stylesheet" href="?css" /><script src="?js"></script></head><body><div class="container"><article><div class="jumbotron"><h1><abbr title="Frequently asked questions">FAQ</abbr></h1></div><h2>What is <?php echo POMF_NAME; ?>?</h2><p><span role="definition"><dfn><?php echo POMF_NAME; ?></dfn> is a simple to use free file hosting service.</span> It lets you share your photos, documents, music, videos and more with others online.</p><h2>What works are allowed?</h2><p><?php echo POMF_NAME; ?> welcomes uploading all works, as long as the work is legal in Australia and you have the legal right to publish the work on our service.</p><p>As an exception to this policy to prevent abuse, we do not allow malware on our service. Any malware that could be used to infect other computers may be removed from our service at our discretion.</p><h2>Do you keep logs of uploaded works?</h2><p>We don't collect or log any data of our users in respect for privacy. We only have files uploaded by our users.</p><h2>Can you remove my copyrighted work?</h2><p>Please submit your copyright takedown notice to <a href="mailto:<?php echo POMF_ABUSE_EMAIL; ?>"><?php echo POMF_ABUSE_EMAIL; ?></a>. We will handle your notice within 24 hours and disable access to the infringing work after receiving a notice compliant with the Copyright Act 1968 (Australia).</p><h2>Can you remove works that are defaming me or otherwise infringing my non-copyright rights?</h2><p><?php echo POMF_NAME; ?> respects takedowns for other works when accompanied with a certified Australian court order. If you are unable to obtain the order, a preliminary injuction or court order is typically also sufficient. Please forward the notice to <a href="mailto:<?php echo POMF_ABUSE_EMAIL; ?>"><?php echo POMF_ABUSE_EMAIL; ?></a>.</p><h2>Can you remove illegal works?</h2><p>Please contact the appropriate law enforcement agency if you notice illegal works hosted on Pantsu.cat. We have not been trained or qualified to investigate and fight crimes and enforce the law, so it's not appropriate to send accusations of illegal activity to us. <strong>You must contact the appropriate law enforcement office.</strong> They may then contact us if appropriate.</p><p>If you are an Australian law enforcement official and you need our assistance, please contact <a href="mailto:<?php echo POMF_ABUSE_EMAIL; ?>"><?php echo POMF_ABUSE_EMAIL; ?></a>. If you are a law enforcement official from another country, we may voluntarily cooperate if the crime you are investigating would also be illegal in Australia.</p><h2>I have a question...</h2><p>Send us an email at <a href="mailto:<?php echo POMF_INFO_EMAIL; ?>"><?php echo POMF_INFO_EMAIL; ?></a> and let's talk!</p></article><nav><ul><li><a href="?"><?php echo POMF_NAME; ?></a></li><li><a href="?tools">Tools</a></li><li><a href="https://github.com/ewasion/flat-chested">Git</a></li></ul></nav></div></body></html><?php
    exit;
}

if(isset($_GET['tools'])) {?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta name="generator" content="Pomf &lt;%= pkg.version %&gt;" /><title><?php echo POMF_NAME; ?> &middot; Tools</title><link rel="icon" href="favicon.ico" /><link rel="stylesheet" href="?css" /><script src="?js"></script></head><body><div class="container"><div class="jumbotron"><h1>Pomf Tools</h1></div><section><h2>pomfload</h2><dl><dt>Download</dt><dd><a href="https://github.com/ewhal/pomfload">https://github.com/ewhal/pomfload</a></dd><dt>Contact</dt><dd><a href="https://twitter.com/AnonymousLink">https://twitter.com/AnonymousLink</a></dd></dl></section><section><h2>limf</h2><dl><dt>Download</dt><dd><a href="https://github.com/lich/limf">https://github.com/lich/limf</a></dd><dt>Contact</dt><dd><a href="http://lich.github.io/">http://lich.github.io/</a></dd></dl></section><section><h2>1339secure</h2><dl><dt>Download</dt><dd><a href="https://github.com/AdrianKoshka/1339secure">https://github.com/AdrianKoshka/1339secure</a></dd><dt>Contact</dt><dd><a href="mailto:adriankoshcha@teknik.io">adriankoshcha@teknik.io</a></dd></dl></section><section><h2>ShareX</h2><dl><dt>Download</dt><dd><a href="https://github.com/ShareX/ShareX/">https://github.com/ShareX/ShareX/</a></dd><dt>Settings</dt><dd><a href="https://p.pantsu.cat/view/raw/8c36da7e">https://p.pantsu.cat/view/raw/8c36da7e</a></dd></dl></section><section><h2>Gyazowin</h2><dl><dt>Download</dt><dd><a href="https://github.com/avail/gyazowin">https://github.com/avail/gyazowin</a></dd><dt>Contact</dt><dd><a href="https://twitter.com/4vail">https://twitter.com/4vail</a></dd></dl></section><section><h2>Pomfshare</h2><dl><dt>Download</dt><dd><a href="https://github.com/Nyubis/Pomfshare">https://github.com/Nyubis/Pomfshare</a></dd><dt>Contact</dt><dd><a href="https://github.com/Nyubis">https://github.com/Nyubis</a></dd></dl></section><section><h2>Pomf Rehost</h2><dl><dt>Download</dt><dd><a href="https://git.fuwafuwa.moe/lesderid/pomf-rehost">https://git.fuwafuwa.moe/lesderid/pomf-rehost</a></dd><dt>Contact</dt><dd><a href="mailto:les@fuwafuwa.moe">les@fuwafuwa.moe</a></dd></dl></section><nav><ul><li><a href="?"><?php echo POMF_NAME; ?></a></li><li><a href="?tools">Tools</a></li><li><a href="https://github.com/ewasion/flat-chested">Git</a></li></ul></nav></div></body></html><?php
    exit;
}

/* Grills */

if(isset($_GET['grill'])) {
    $images = array(
        'img/2.png',
        'img/3.png',
        'img/4.png',
        'img/5.png',
        'img/6.png',
        'img/7.png',
        'img/8.png',
        'img/9.png',
        'img/10.png',
    );
    
    if (headers_sent() === false) {
        header('Location: '.$images[array_rand($images)], true, 303);
    }
    exit;
}


if(!isset($_GET['upload'])) {?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta name="generator" content="Pomf &lt;%= pkg.version %&gt;" /><title><?php echo POMF_NAME; ?> &middot; <?php echo POMF_SLOGAN; ?></title><link rel="icon" href="favicon.ico" /><link rel="stylesheet" href="?css" /><script src="?js"></script></head><body><div class="container"><div class="jumbotron"><h1><?php echo POMF_NAME; ?>~</h1><p class="lead">Max upload size is <?php echo ini_get('upload_max_filesize').'B'; ?>, read the <a href="?faq"><abbr title="Frequently asked questions">FAQ</abbr></a></p><form id="upload-form" enctype="multipart/form-data" method="post" action="?upload=html"><button id="upload-btn" class="btn" type="button">Select or drop file(s)</button><input type="file" id="upload-input" name="files[]" multiple data-max-size="<?php echo ini_get('upload_max_filesize').'B'; ?>"><input type="submit" value="Submit"></form><ul id="upload-filelist"></ul></div><p class="alert alert-error"><strong>Malware scans are run daily</strong> &mdash; files identified as malware will be removed without further notice.
</p><p class="alert alert-info"><strong><?php echo POMF_NAME; ?> is free to use, but our hosting costs are far from it</strong> &mdash; donations are what keep <?php echo POMF_NAME; ?> alive, free, and fast.<span class="donate-btns"></span></p><nav><ul><li><a href="?"><?php echo POMF_NAME; ?></a></li><li><a href="?tools">Tools</a></li><li><a href="https://github.com/ewasion/flat-chested">Git</a></li></ul></nav></div></body></html><?php
    exit;
}

/* Upload */

/**
 * Returns a human readable error description for file upload errors.
 *
 * @author Dan Brown <danbrown@php.net>
 * @author Michiel Thalen
 * @copyright Copyright © 1997 - 2016 by the PHP Documentation Group
 * @license
 * UploadException is licensed under a Creative Commons Attribution 3.0 License
 * or later.
 *
 * Based on a work at
 * https://secure.php.net/manual/en/features.file-upload.errors.php#89374.
 *
 * You should have received a copy of the Creative Commons Attribution 3.0
 * License with this program. If not, see
 * <https://creativecommons.org/licenses/by/3.0/>.
 */

class UploadException extends Exception
{
    public function __construct($code)
    {
        $message = $this->codeToMessage($code);
        parent::__construct($message, 500);
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was '.
                           'specified in the HTML form';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'File upload stopped by extension';
                break;

            default:
                $message = 'Unknown upload error';
                break;
        }

        return $message;
    }
}

class UploadedFile
{
    /* Public attributes */
    public $name;
    public $mime;
    public $size;
    public $tempfile;
    public $error;

    /**
     * SHA-1 checksum
     *
     * @deprecated 2.1.0 To be replaced with SHA-256 hashing.
     * @var string 40 digit hexadecimal hash (160 bits)
     */
    private $sha1;

    /**
     * Generates the SHA-1 or returns the cached SHA-1 hash for the file.
     *
     * @return string|false $sha1
     */
    public function getSha1()
    {
        if (!$this->sha1) {
            $this->sha1 = @sha1_file($this->tempfile);
        }

        return $this->sha1;
    }
}

/**
 * The Response class is a do-it-all for getting responses out in different
 * formats.
 *
 * @todo Create sub-classes to split and extend this god object.
 */
class Response
{
    /**
     * Indicates response type used for routing.
     *
     * Valid strings are 'csv', 'html', 'json' and 'text'.
     *
     * @var string $type Response type
     */
    private $type;

    /**
     * Indicates requested response type.
     *
     * Valid strings are 'csv', 'html', 'json', 'gyazo' and 'text'.
     *
     * @param string|null $response_type Response type
     */
    public function __construct($response_type = null)
    {
        switch ($response_type) {
            case 'csv':
                header('Content-Type: text/csv; charset=UTF-8');
                $this->type = $response_type;
                break;
            case 'html':
                header('Content-Type: text/html; charset=UTF-8');
                $this->type = $response_type;
                break;
            case 'json':
                header('Content-Type: application/json; charset=UTF-8');
                $this->type = $response_type;
                break;
            case 'gyazo':
                // Deprecated API since version 2.0.0, fallback to similar text API
                header('Content-Type: text/plain; charset=UTF-8');
                $this->type = 'text';
                break;
            case 'text':
                header('Content-Type: text/plain; charset=UTF-8');
                $this->type = $response_type;
                break;
            default:
                header('Content-Type: application/json; charset=UTF-8');
                $this->type = 'json';
                $this->error(400, 'Invalid response type. Valid options are: csv, html, json, text.');
                break;
        }
    }

    /**
     * Routes error messages depending on response type.
     *
     * @param int $code HTTP status code number.
     * @param int $desc Descriptive error message.
     * @return void
     */
    public function error($code, $desc)
    {
        $response = null;

        switch ($this->type) {
            case 'csv':
                $response = $this->csvError($desc);
                break;
            case 'html':
                $response = $this->htmlError($code, $desc);
                break;
            case 'json':
                $response = $this->jsonError($code, $desc);
                break;
            case 'text':
                $response = $this->textError($code, $desc);
                break;
        }

        http_response_code(500); // "500 Internal Server Error"
        echo $response;
    }

    /**
     * Routes success messages depending on response type.
     *
     * @param mixed[] $files
     * @return void
     */
    public function send($files)
    {
        $response = null;

        switch ($this->type) {
            case 'csv':
                $response = $this->csvSuccess($files);
                break;
            case 'html':
                $response = $this->htmlSuccess($files);
                break;
            case 'json':
                $response = $this->jsonSuccess($files);
                break;
            case 'text':
                $response = $this->textSuccess($files);
                break;
        }

        http_response_code(200); // "200 OK". Success.
        echo $response;
    }

    /**
     * Indicates with CSV body the request was invalid.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param int $description Descriptive error message.
     * @return string Error message in CSV format.
     */
    private static function csvError($description)
    {
        return '"error"'."\r\n"."\"$description\""."\r\n";
    }

    /**
     * Indicates with CSV body the request was successful.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param mixed[] $files
     * @return string Success message in CSV format.
     */
    private static function csvSuccess($files)
    {
        $result = '"name","url","hash","size"'."\r\n";
        foreach ($files as $file) {
            $result .= '"'.$file['name'].'"'.','.
                       '"'.$file['url'].'"'.','.
                       '"'.$file['hash'].'"'.','.
                       '"'.$file['size'].'"'."\r\n";
        }

        return $result;
    }

    /**
     * Indicates with HTML body the request was invalid.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param int $code HTTP status code number.
     * @param int $description Descriptive error message.
     * @return string Error message in HTML format.
     */
    private static function htmlError($code, $description)
    {
        return '<p>ERROR: ('.$code.') '.$description.'</p>';
    }

    /**
     * Indicates with HTML body the request was successful.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param mixed[] $files
     * @return string Success message in HTML format.
     */
    private static function htmlSuccess($files)
    {
        $result = '';

        foreach ($files as $file) {
            $result .=  '<a href="'.$file['url'].'">'.$file['url'].'</a><br>';
        }

        return $result;
    }

    /**
     * Indicates with JSON body the request was invalid.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param int $code HTTP status code number.
     * @param int $description Descriptive error message.
     * @return string Error message in pretty-printed JSON format.
     */
    private static function jsonError($code, $description)
    {
        return json_encode(array(
            'success' => false,
            'errorcode' => $code,
            'description' => $description,
        ), JSON_PRETTY_PRINT);
    }

    /**
     * Indicates with JSON body the request was successful.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param mixed[] $files
     * @return string Success message in pretty-printed JSON format.
     */
    private static function jsonSuccess($files)
    {
        return json_encode(array(
            'success' => true,
            'files' => $files,
        ), JSON_PRETTY_PRINT);
    }

    /**
     * Indicates with plain text body the request was invalid.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param int $code HTTP status code number.
     * @param int $description Descriptive error message.
     * @return string Error message in plain text format.
     */
    private static function text_error($code, $description)
    {
        return 'ERROR: ('.$code.') '.$description;
    }

    /**
     * Indicates with plain text body the request was successful.
     *
     * @deprecated 2.1.0 Will be renamed to camelCase format.
     * @param mixed[] $files
     * @return string Success message in plain text format.
     */
    private static function text_success($files)
    {
        $result = '';

        foreach ($files as $file) {
            $result .= $file['url']."\n";
        }

        return $result;
    }
}

/**
 * Generates a random name for the file, retrying until we get an unused one.
 *
 * @param UploadedFile $file
 *
 * @return string
 */
function generateName($file)
{
    global $doubledots;

    // We start at N retries, and --N until we give up
    $tries = POMF_FILES_RETRIES;
    $length = POMF_FILES_LENGTH;
    $ext = pathinfo($file->name, PATHINFO_EXTENSION);

    // Check if extension is a double-dot extension and, if true, override $ext
    $revname = strrev($file->name);
    foreach ($doubledots as $ddot) {
        if (stripos($revname, $ddot) === 0) {
            $ext = strrev($ddot);
        }
    }

    do {
        // Iterate until we reach the maximum number of retries
        if ($tries-- === 0) {
            throw new Exception(
                'Gave up trying to find an unused name',
                500
            ); // HTTP status code "500 Internal Server Error"
        }

        $chars = ID_CHARSET;
        $name = '';
        for ($i = 0; $i < $length; ++$i) {
            $name .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        // Add the extension to the file name
        if (isset($ext) && $ext !== '') {
            $name .= '.'.strip_tags($ext);
        }

        // Check if a file with the same name does already exist
        $result = file_exists(POMF_FILES_PATH.$name);
    // If it does, generate a new name
    } while ($result === true);

    return $name;
}

/**
 * Handles the uploading and db entry for a file.
 *
 * @param UploadedFile $file
 *
 * @return array
 */
function uploadFile($file)
{
    global $FILTER_MODE;
    global $FILTER_MIME;

    // Handle file errors
    if ($file->error) {
        throw new UploadException($file->error);
    }

    // Check if mime type is blocked
    if (!empty($FILTER_MIME)) {
        if ($FILTER_MODE == true) { //whitelist mode
            if (!in_array($file->mime, $FILTER_MIME)) {
                throw new UploadException(UPLOAD_ERR_EXTENSION);
            }
        } else { //blacklist mode
            if (in_array($file->mime, $FILTER_MIME)) {
                throw new UploadException(UPLOAD_ERR_EXTENSION);
            }
        }
    }


    // Check if a file with the same hash and size (a file which is the same)
    // does already exist in the database; if it does, return the proper link
    // and data. PHP deletes the temporary file just uploaded automatically.
    $files = [];
    foreach(glob(POMF_FILES_PATH.'*', GLOB_NOSORT) as $path) {
        $files[$path] = filesize($path);
    }
    $result = array_search($file->size, $files);
    if ($result !== false) {
        if(sha1_file($result) === $file->getSha1()) {
            return array(
                'hash' => $file->getSha1(),
                'name' => $file->name,
                'url' => POMF_URL.substr($result, strlen(POMF_FILES_PATH)),
                'size' => $file->size,
            );
        }
    }

    // Generate a name for the file
    $newname = generateName($file);

    // Store the file's full file path in memory
    $uploadFile = POMF_FILES_PATH . $newname;

    // Attempt to move it to the static directory
    if (!move_uploaded_file($file->tempfile, $uploadFile)) {
        throw new Exception(
            'Failed to move file to destination',
            500
        ); // HTTP status code "500 Internal Server Error"
    }

    // Need to change permissions for the new file to make it world readable
    if (!chmod($uploadFile, 0644)) {
        throw new Exception(
            'Failed to change file permissions',
            500
        ); // HTTP status code "500 Internal Server Error"
    }

    return array(
        'hash' => $file->getSha1(),
        'name' => $file->name,
        'url' => POMF_URL.$newname,
        'size' => $file->size,
    );
}

/**
 * Reorder files array by file.
 *
 * @param  $_FILES
 *
 * @return array
 */
function diverseArray($files)
{
    $result = array();

    foreach ($files as $key1 => $value1) {
        foreach ($value1 as $key2 => $value2) {
            $result[$key2][$key1] = $value2;
        }
    }

    return $result;
}

/**
 * Reorganize the $_FILES array into something saner.
 *
 * @param  $_FILES
 *
 * @return array
 */
function refiles($files)
{
    $result = array();
    $files = diverseArray($files);

    foreach ($files as $file) {
        $f = new UploadedFile();
        $f->name = $file['name'];
        $f->mime = $file['type'];
        $f->size = $file['size'];
        $f->tempfile = $file['tmp_name'];
        $f->error = $file['error'];
        // 'expire' doesn't exist neither in $_FILES nor in UploadedFile;
        // it was never implemented and has been deprecated since version 2.1.0.
        //$f->expire   = $file['expire'];
        $result[] = $f;
    }

    return $result;
}

$type = !empty($_GET['upload']) ? $_GET['upload'] : 'json';
$response = new Response($type);

if (isset($_FILES['files'])) {
    $uploads = refiles($_FILES['files']);

    try {
        foreach ($uploads as $upload) {
            $res[] = uploadFile($upload);
        }
        $response->send($res);
    } catch (Exception $e) {
        $response->error($e->getCode(), $e->getMessage());
    }
} else {
    $response->error(400, 'No input file(s)');
}
