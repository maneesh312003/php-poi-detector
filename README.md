# PHP Object Injection (POI) Detector

> MSc Cybersecurity Dissertation — University of Liverpool (COMP702)  
> Supervised by Dr. Wanpeng Li | Expected Submission: September 2026

## Overview

PHP Object Injection (POI) is a critical vulnerability class listed in the OWASP Top 10 that arises when user-supplied input is passed to PHP's `unserialize()` function without proper validation. This allows attackers to instantiate arbitrary PHP objects and chain them via magic methods (`__wakeup`, `__destruct`, `__toString`) to achieve Remote Code Execution, SQL Injection, or file system manipulation.

This project develops an **automated white-box static analysis tool** to detect POI vulnerabilities in PHP codebases, combined with **targeted fuzzing** to confirm exploitability — reducing false positives that plague traditional SAST tools.

## Research Objectives

- Identify all `unserialize()` call sites in a PHP codebase via AST-based static analysis
- Perform taint analysis to trace whether user-controlled data reaches vulnerable sinks
- Enumerate available PHP Object Inheritance (POP) chain gadgets within the codebase
- Generate targeted fuzzing payloads to confirm exploitability
- Evaluate detection accuracy against real-world PHP applications

## Methodology
Source Code
│
▼
AST Parsing (php-parser)
│
▼
Taint Analysis ──► Identify unserialize() sinks reachable from user input
│
▼
POP Chain Enumeration ──► Identify exploitable magic method chains
│
▼
Fuzzing Payload Generation ──► Serialised PHP object payloads
│
▼
Vulnerability Report

## Tech Stack

| Component | Technology |
|---|---|
| Language | Python |
| PHP Parsing | php-parser / custom AST walker |
| Taint Analysis | Custom static analyser |
| Fuzzing | Targeted payload generation |
| Target Language | PHP 7.x / 8.x |

## Project Status

🔬 **In Progress** — Active dissertation research (Jan 2026 – Sep 2026)

- [x] Literature review and threat modelling
- [x] Tool architecture designed
- [ ] AST parser and taint analysis engine (in development)
- [ ] POP chain enumerator
- [ ] Fuzzing module
- [ ] Evaluation against test PHP applications
- [ ] Final dissertation write-up

## Related Concepts

- OWASP Top 10: A08 — Software and Data Integrity Failures
- CWE-502: Deserialization of Untrusted Data
- White-box Static Analysis / SAST
- Magic Method Exploitation in PHP

## Academic Context

This research contributes to the field of automated vulnerability detection, specifically targeting insecure deserialisation in PHP — a vulnerability class that has affected major platforms including WordPress plugins, Laravel, and Magento.

## Author

**Maneesh Madhukumar**  
MSc Cybersecurity, University of Liverpool  
[LinkedIn](https://linkedin.com/in/maneeshmadhukumar312003)

