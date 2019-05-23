## batch-obfuscator
Easy way to obfuscuate batch files (Windows)

https://edgardguerinot.com/batch-obfuscator/

![1](https://raw.githubusercontent.com/SkywalkerFR/batch-obfuscator/master/1.png)
![2](https://raw.githubusercontent.com/SkywalkerFR/batch-obfuscator/master/2.png)

## How it works ?

1) Modify UTF-8 to UTF-16 with BOM `\xFF\xFE`
2) Clear artefact in the terminal and create variable that contains all symbols
3) For each character, replace it with the appropriate chain chunk (exepts some things like labels)

Done!
