<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use BrowserDetect;
use File;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    private $base_url = 'http://10.86.195.49:8081';               //线上

//    private $base_url = 'http://10.115.61.77:9081';

    public function home(Request $request)
    {
        if (BrowserDetect::isMobile()) {
            return view('front/mobile');
        }

        return File::get('dist/pcHome.html');
    }

    public function events(Request $request)
    {
        if (BrowserDetect::isMobile()) {
            return view('front/mobileEvents');
        }

        return File::get('dist/pcEvents.html');
    }

    public function reports($type)
    {
        if (intval($type) !== 1 && intval($type) !== 2) {
            return;
        }

        if (BrowserDetect::isMobile()) {
            return view('front/mobileReports')
                ->with('type', $type);
        }

        if ($type == 1) {
            return File::get('dist/pcReports.html');
        }

        return File::get('dist/pcVulnerabilities.html');
    }

    public function successCase(Request $request)
    {
        $id = $request->get('id');

        if (BrowserDetect::isMobile()) {
            return view('front/successCaseMobile')
                ->with('id', $id);
        }

        return File::get('dist/pcSuccessCase.html');
    }

    public function vulnerabilitiesDetail()
    {
        return view('front/vulnerabilitiesDetail');
    }


    public function eventSummary(Request $request)
    {
        set_time_limit(0);

        return response()->json(["UserTotal" => 70972470, "EventTotal" => 12251361793, "VirusTotal" => 33050633, "Success" => true, "EventIncrease" => 102749148]);


        $client = new Client();

        $res = $client->request('GET', $this->base_url . '/security_lib/v1/event/summary', ['query' => []]);

        return $res->getBody();
    }

    public function mobileVirusMap(Request $request)
    {
        set_time_limit(0);
        return '{"Data": {"gw": 1, "gu": 7, "gt": 584, "gr": 1429, "gq": 17, "gp": 81, "gy": 137, "gf": 72, "ge": 361, "gd": 39, "gb": 4230, "ga": 223, "gn": 256, "gm": 13, "gl": 2, "gi": 3, "gh": 1388, "iq": 2590, "tz": 956, "lc": 21, "la": 657, "tw": 381, "tt": 244, "tr": 4312, "lk": 465, "lv": 101, "to": 2, "tl": 59, "tm": 96, "tj": 216, "ls": 62, "th": 6555, "tg": 219, "td": 23, "tc": 25, "ly": 699, "do": 1265, "dm": 32, "dj": 24, "dk": 89, "um": 1, "de": 4311, "ye": 657, "me": 171, "dz": 5348, "ma": 1169, "yt": 17, "qa": 361, "zm": 321, "ee": 54, "eg": 2682, "za": 582, "ec": 1635, "sg": 594, "mk": 348, "et": 362, "zw": 191, "es": 5331, "er": 1, "ru": 12977, "rw": 163, "rs": 1162, "re": 136, "it": 3231, "ro": 1276, "bd": 4635, "be": 249, "bf": 191, "bg": 709, "ba": 878, "bb": 86, "bm": 6, "bn": 77, "bo": 1102, "bh": 145, "bi": 92, "bj": 190, "bt": 70, "jm": 540, "jo": 353, "bq": 13, "br": 17755, "bs": 906, "je": 4, "by": 937, "bz": 17, "om": 354, "my": 5489, "ky": 16, "bw": 46, "ck": 3, "ci": 435, "ch": 76, "co": 6048, "cn": 297, "cm": 1375, "cl": 4064, "ca": 2073, "cg": 161, "cf": 8, "cd": 296, "cz": 725, "cy": 96, "cr": 152, "cw": 22, "cv": 25, "cu": 69, "ve": 1430, "pr": 271, "ps": 142, "pt": 1900, "py": 431, "lt": 138, "ai": 6, "pa": 341, "pf": 110, "pg": 109, "pe": 3650, "lr": 163, "ph": 12823, "pl": 1882, "hr": 1465, "ht": 219, "hu": 953, "hk": 413, "lu": 38, "hn": 324, "vn": 4307, "pk": 3855, "jp": 2821, "lb": 569, "md": 264, "mg": 158, "mf": 4, "uy": 1289, "mc": 35, "uz": 389, "mm": 839, "ml": 111, "mo": 18, "mn": 133, "mh": 6, "us": 14436, "mu": 142, "mt": 26, "mw": 80, "mv": 127, "mq": 103, "mr": 126, "im": 3, "ug": 304, "ua": 6699, "mx": 28514, "mz": 354, "vc": 111, "ae": 909, "ad": 7, "ag": 37, "vg": 4, "tn": 981, "is": 5, "ir": 3076, "am": 292, "al": 283, "ao": 92, "kn": 5, "as": 3, "ar": 5108, "au": 861, "vu": 13, "aw": 16, "in": 67108, "az": 952, "ie": 492, "id": 16804, "ni": 298, "nl": 814, "no": 46, "il": 293, "na": 105, "nc": 39, "ne": 119, "ng": 3381, "nz": 212, "np": 780, "kw": 406, "fr": 4254, "io": 1, "af": 214, "kz": 742, "fi": 62, "fj": 73, "fm": 2, "fo": 1, "sz": 17, "sy": 618, "sx": 5, "kg": 431, "ke": 961, "ss": 80, "sr": 118, "ki": 4, "kh": 369, "sv": 771, "km": 14, "st": 10, "sk": 106, "kr": 288, "si": 125, "so": 202, "sn": 390, "sm": 1, "sl": 31, "sc": 35, "sb": 5, "sa": 1796, "at": 329, "se": 112, "sd": 1392}, "Success": true}';
        $client = new Client();

        $res = $client->request('GET', $this->base_url . '/security_lib/v1/event/map', ['query' => ['type' => 'VirusMap']]);

        return $res->getBody();
    }

    public function mobileTopVirus(Request $request)
    {
        set_time_limit(0);
        return '{"Data": {"Malware.Generic.5788a89c98": 4791, "Trojan.Hiddad.B6d20e796f": 3927, "Malware.Generic.9972b56f49": 2972, "Malware.Generic.768b585373": 5764, "Malware.Generic.7cc4baa0eb": 7588, "Trojan-dropper.Agent.047e4e7c90": 5298, "Suspicious.Generic.78c4e7a8d6": 13109, "Trojan.Loki.Da39a3ee5e": 3611, "Malware.Generic.Bf9ad82ed1": 3881, "Risktool.Dnotua.301803e9b9": 72397}, "Success": true}';
        $client = new Client();

        $res = $client->request('GET', $this->base_url . '/security_lib/v1/event/top', ['query' => ['type' => 'TopVirus']]);

        return $res->getBody();
    }

    public function mobileVirusIncrease(Request $request)
    {
        set_time_limit(0);
        return '{"Data": [{"2017-08-17": 316208}, {"2017-08-18": 329482}, {"2017-08-19": 333606}, {"2017-08-20": 338049}, {"2017-08-21": 357813}, {"2017-08-22": 342286}, {"2017-08-23": 334041}], "Success": true}';
        $client = new Client();

        $res = $client->request('GET', $this->base_url . '/security_lib/v1/event/trends', ['query' => ['type' => 'VirusIncrease']]);

        return $res->getBody();
    }


    public function reportsDetail($type)
    {
        if ($type == 1) {
            if (BrowserDetect::isMobile()) {
                return view('front/mobileReportsDetail');
            }

            return File::get('dist/pcReportsDetail.html');
        } elseif ($type == 2) {
            if (BrowserDetect::isMobile()) {
                return view('front/mobileVulnerabilitiesDetail');
            }

            return File::get('dist/pcvulnerabilitiesDetail.html');
        }
    }

    //type=1:vulnerabilities,type=2:reports
    public function reportsPage($type, $page = -1)
    {
        if ($type != 1 && $type != 2 || !preg_match("/[0-9]+/", $page)) {
            return;
        }

        set_time_limit(0);

        $client = new Client();

        if ($type == 1) {
            return '{"Total": 163, "Data": [{"Date": "2017-09-11", "Risk": 1, "MD5": "67BB88C6F9DB0687614AF5BCCD75FD12"}, {"Date": "2017-09-11", "Risk": 1, "MD5": "BAABEB50BB9256AC28751AE0AFA015CC"}, {"Date": "2017-09-08", "Risk": 2, "MD5": "E28C417CA30581EC43BF2D9C79F8B267"}, {"Date": "2017-09-07", "Risk": 1, "MD5": "528A29BD0892E4AA27AF2E5A551B5FF5"}, {"Date": "2017-09-06", "Risk": 1, "MD5": "853524D49E42EC1F218326AE8353B2DF"}, {"Date": "2017-09-03", "Risk": 1, "MD5": "4112C5BBE221D1032B5979B315A2242A"}, {"Date": "2017-09-02", "Risk": 1, "MD5": "424308E4AAE3493662A3336A423846AD"}, {"Date": "2017-09-02", "Risk": 1, "MD5": "98FDB47121935E5C7B61250DC501C3E3"}, {"Date": "2017-09-02", "Risk": 1, "MD5": "127ED401A046F0AE9E0F859DBAB053F9"}, {"Date": "2017-09-01", "Risk": 1, "MD5": "04F0C9DDC5F181FD2B7A58B7928F72BE"}], "Success": true}';

            $res = $client->request('GET', $this->base_url . '/security_lib/v1/reports/hot_reports', ['query' => ['page' => $page, 'length' => 10]]);

            return $res->getBody();
        } else {
            return '{"Total": 1179, "Data": [[{"CVE": "CVE-2017-0752"}, {"DateReported": "2017-09-05"}, {"Severity": "High"}, {"ExploitsName": "Framework vulnerability"}, {"ExploitsDescription": "Elevation of privilege vulnerability, This vulnerability could enable a local malicious app to access data outside of its permission levels."}, {"References": [{"A-62196835": []}]}, {"UpdatedAOSPVersions": "4.4.4, 5.0.2, 5.1.1, 6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0753"}, {"DateReported": "2017-09-05"}, {"Severity": "High"}, {"ExploitsName": "Libraries vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-62218744": []}]}, {"UpdatedAOSPVersions": "7.1.1, 7.1.2, 8.0"}], [{"CVE": "CVE-2017-6983"}, {"DateReported": "2017-09-05"}, {"Severity": "High"}, {"ExploitsName": "Libraries vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-63852675": []}]}, {"UpdatedAOSPVersions": "4.4.4, 5.0.2, 5.1.1, 6.0, 6.0.1, 7.0, 7.1.1, 7.1.2, 8.0"}], [{"CVE": "CVE-2017-0755"}, {"DateReported": "2017-09-05"}, {"Severity": "High"}, {"ExploitsName": "Libraries vulnerability"}, {"ExploitsDescription": "Elevation of privilege vulnerability, This vulnerability could enable a local malicious app to access data outside of its permission levels."}, {"References": [{"A-32178311": []}]}, {"UpdatedAOSPVersions": "5.0.2, 5.1.1, 6.0, 6.0.1, 7.0, 7.1.1, 7.1.2, 8.0"}], [{"CVE": "CVE-2017-0756"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-34621073": []}]}, {"UpdatedAOSPVersions": "4.4.4, 5.0.2, 5.1.1, 6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0757"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-36006815": []}]}, {"UpdatedAOSPVersions": "6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0758"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-36492741": []}]}, {"UpdatedAOSPVersions": "5.0.2, 5.1.1, 6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0759"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-36715268": []}]}, {"UpdatedAOSPVersions": "6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0760"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-37237396": []}]}, {"UpdatedAOSPVersions": "6.0, 6.0.1, 7.0, 7.1.1, 7.1.2"}], [{"CVE": "CVE-2017-0761"}, {"DateReported": "2017-09-05"}, {"Severity": "Critical"}, {"ExploitsName": "Media Framework vulnerability"}, {"ExploitsDescription": "Remote code execution vulnerability, This vulnerability could enable an attacker using a specially crafted file to execute arbitrary code within the context of an unprivileged process."}, {"References": [{"A-38448381": []}]}, {"UpdatedAOSPVersions": "6.0, 6.0.1, 7.0, 7.1.1, 7.1.2, 8.0"}]], "Success": true}';
            if (BrowserDetect::isMobile()) {
                $res = $client->request('GET', $this->base_url . '/security_lib/v1/vulnerabilities/vulnerabilities', ['query' => ['page' => $page, 'length' => 10]]);

                return $res->getBody();
            }

            $res = $client->request('GET', $this->base_url . '/security_lib/v1/vulnerabilities/vulnerabilitiespc', ['query' => ['page' => $page, 'length' => 10]]);

            return $res->getBody();
        }
    }

    public function mobileReportsDetail($md5)
    {
        return '{"Date": "2017-09-07", "Data": [{"Basic": [{"AppName": "File"}, {"MD5": "528A29BD0892E4AA27AF2E5A551B5FF5"}, {"SHA1": "68E441F19A4C59C3AF292080F1ED12912394D4D0"}, {"SHA256": "3B0A68DB5FB8FE469B4C032C95D25226CB82FF1A6CB5A631CEFCFD382FCA97D4"}, {"FileSize": 701158.0}, {"UpdateTime": "2017-09-08 02:00:30"}, {"PkgeName": "com.google.packagemanager.file2"}, {"MinSdkVersion": "Android 2.3/2.3.1/2.3.2"}]}, {"CertificateInfo": {"Certificate_Md5": "08:BB:9A:65:59:6B:B0:20:64:E8:FA:7E:35:D0:EE:04", "Valid from": "Fri Aug 25 02:51:46 UTC 2017 until: Sat May 28 02:51:46 UTC 2072", "Serial number": "3631e077", "Issuer": "CN=xqbie, OU=jqfrrqyw, O=ymigxeuu, L=psbezr, ST=uvxwwv, C=pk", "Certificate_SHA256": "A4:90:05:C0:63:FD:6E:8F:C8:FD:AE:78:69:AF:07:DE:BB:F4:55:37:A9:D9:7D:83:65:DA:F7:12:25:59:8F:8C", "Owner": "CN=xqbie, OU=jqfrrqyw, O=ymigxeuu, L=psbezr, ST=uvxwwv, C=pk", "Certificate_Version": "3", "Certificate_SigAlgName": "SHA256withRSA", "Certificate_SHA1": "74:CE:29:A9:D3:31:5E:56:04:D0:03:95:B5:23:B7:09:0C:9B:74:61"}}, {"Permissions": [{"android.permission.WRITE_EXTERNAL_STORAGE": {"Risk": 0.0, "Desc": "Allows an application to write to external storage."}}, {"android.permission.VIBRATE": {"Risk": 0.0, "Desc": "Allows access to the vibrator."}}, {"android.permission.DISABLE_KEYGUARD": {"Risk": 2.0, "Desc": "Allows applications to disable the keyguard if it is not secure."}}, {"android.permission.SYSTEM_ALERT_WINDOW": {"Risk": 0.0, "Desc": "Allows an app to create windows using the type TYPE_APPLICATION_OVERLAY, shown on top of all other apps."}}, {"android.permission.WRITE_SETTINGS": {"Risk": 0.0, "Desc": "Allows an application to read or write the system settings."}}, {"android.permission.ACCESS_NETWORK_STATE": {"Risk": 0.0, "Desc": "Allows applications to access information about networks."}}, {"android.permission.ACCESS_WIFI_STATE": {"Risk": 1.0, "Desc": "Allows applications to access information about Wi-Fi networks."}}, {"android.permission.INTERNET": {"Risk": 0.0, "Desc": "Allows applications to open network sockets."}}, {"android.permission.BROADCAST_STICKY": {"Risk": 0.0, "Desc": "Allows an application to broadcast sticky intents."}}, {"android.permission.READ_PHONE_STATE": {"Risk": 2.0, "Desc": "Allows read only access to phone state, including the phone number of the device, current cellular network information, the status of any ongoing calls, and a list of any PhoneAccounts registered on the device."}}, {"android.permission.CHANGE_NETWORK_STATE": {"Risk": 0.0, "Desc": "Allows applications to change network connectivity state."}}, {"android.permission.CHANGE_WIFI_STATE": {"Risk": 2.0, "Desc": "Allows applications to change Wi-Fi connectivity state."}}, {"com.android.launcher.permission.INSTALL_SHORTCUT": {"Risk": 0.0, "Desc": "N/A"}}, {"android.permission.GET_TASKS": {"Risk": 2.0, "Desc": "This constant was deprecated in API level 21. No longer enforced."}}, {"android.permission.RECEIVE_BOOT_COMPLETED": {"Risk": 0.0, "Desc": "Allows an application to receive the ACTION_BOOT_COMPLETED that is broadcast after the system finishes booting."}}, {"android.permission.ACCESS_COARSE_LOCATION": {"Risk": 2.0, "Desc": "Allows an app to access approximate location."}}, {"android.permission.ACCESS_FINE_LOCATION": {"Risk": 2.0, "Desc": "Allows an app to access precise location."}}, {"android.permission.INSTALL_PACKAGES": {"Risk": 1.0, "Desc": "Allows an application to install packages."}}, {"android.permission.READ_CONTACTS": {"Risk": 2.0, "Desc": "Allows an application to read the user\'s contacts data."}}, {"android.permission.REAL_GET_TASKS": {"Risk": 0.0, "Desc": "N/A"}}]}, {"Activities": ["com.z.a", "com.z.b", "com.k.s.ka"]}, {"Services": ["com.z.s", "com.a.g.sa", "com.a.g.sb"]}, {"Receivers": ["com.z.r", "com.z.c", "com.z.d", "com.a.g.ra", "com.a.g.rb"]}, {"DexStringHttp": ""}, {"FilesCount": 16.0}], "Success": true, "Level": 1.0}';

        set_time_limit(0);

        $client = new Client();
        $res = $client->request('GET', $this->base_url . '/security_lib/v1/reports/show_detail', ['query' => ['md5' => $md5]]);

        return $res->getBody();
    }

    public function mobileVulnerabilitiesDetail($cve)
    {
        set_time_limit(0);

        $client = new Client();
        $res = $client->request('GET', $this->base_url . '/security_lib/v1/vulnerabilities/show_vulnerabilities', ['query' => ['cve' => $cve]]);

        return $res->getBody();
    }

    public function version()
    {
        return response()->json(json_decode(file_get_contents('https://s3.amazonaws.com/tcl-hisecuritylab/applist/version')));
    }
}

