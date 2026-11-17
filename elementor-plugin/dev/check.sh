#!/usr/bin/env bash
# Lints every PHP file and runs the offline harness. Usage: bash elementor-plugin/dev/check.sh
set -e
cd "$(dirname "$0")/.."
PHP="nix run nixpkgs#php --"
for f in $(find labconnect-widgets -name '*.php'); do $PHP -l "$f" | grep -v "No syntax errors" || true; done
$PHP dev/harness.php > /tmp/lcw.json
python3 - <<'PY'
import json
d=json.load(open('/tmp/lcw.json'))
bad=0
for w in d:
    if w.get('missing'): print('MISSING', w['file']); continue
    if w['errors']: bad+=1; print('ERR', w['file'], w['errors'][:8])
print(len(d),'widgets,', sum(not w.get('missing') for w in d),'present,', bad,'with errors,', sum(w.get('controls',0) for w in d),'controls')
PY
