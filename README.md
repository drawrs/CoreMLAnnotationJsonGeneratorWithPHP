# CoreMLAnnotationJsonGeneratorWithPHP
an php script that can help you to generate annotation.json based on you xmls label files.

Requirements:
- PHP Apache (I using MAMMP)
- XML Annotation label files

Labeling Software: https://github.com/tzutalin/labelImg

Step:
1. Copy all this files to root of your apache (e.g: MAMMP, put in inside the htdocs folder)
2. Copy all your xml files to the ./xmls folder
3. Start your php service
4. Execute the converter.php by visiting localhost/CoreMlAnnotationJsonGeneratorWithPHP/converter.php
5. File annotations.json will be automatically generated inside the script directory


