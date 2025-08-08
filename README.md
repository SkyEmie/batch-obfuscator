# Batch Obfuscator
Easy way to obfuscate Windows batch files

Note:
This is created for educational purposes.  
Since batch files are interpreted by the command prompt (cmd.exe), it's of course possible for anyone (with sufficient knowledge) to understand what an obfuscated batch file does and make it humanly readable.  
But it's a basic functional demonstration of what can potentially be done to make the contents of a batch file humanly unreadable.

## How it works?
1) It changes the file encoding (UTF-8 to UTF-16 with BOM `\xFF\xFE`)
2) Clear artefact in the terminal, and create variable that contains all symbols
3) For each character, replace it with the appropriate chain chunk (except some things like labels)
Done!

## Demo
Demo here: http://77.237.242.134/batch-obfuscator/

## Example
![1](https://raw.githubusercontent.com/SkyEmie/batch-obfuscator/master/1.png)
![2](https://raw.githubusercontent.com/SkyEmie/batch-obfuscator/master/2.png)


