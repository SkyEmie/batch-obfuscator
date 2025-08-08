<?php
declare(strict_types=1);
ini_set('memory_limit', '512M');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="favicon.ico">
    <title>Batch File Obfuscator</title>
    
    <style type="text/css">
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: #161b22;
            --bg-tertiary: #21262d;
            --bg-quaternary: #30363d;
            --border-primary: #30363d;
            --border-secondary: #21262d;
            --text-primary: #f0f6fc;
            --text-secondary: #8b949e;
            --text-tertiary: #6e7681;
            --accent-primary: #238636;
            --accent-secondary: #2ea043;
            --accent-danger: #da3633;
            --accent-warning: #fb8500;
            --accent-info: #0969da;
            --shadow-primary: rgba(0, 0, 0, 0.3);
            --shadow-secondary: rgba(0, 0, 0, 0.15);
            --gradient-primary: linear-gradient(135deg, #238636 0%, #2ea043 100%);
            --gradient-secondary: linear-gradient(135deg, #0969da 0%, #1f6feb 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
        }

        html, body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        body {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(35, 134, 54, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(9, 105, 218, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(251, 133, 0, 0.05) 0%, transparent 50%);
            background-attachment: fixed;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .version {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.875rem;
            border: 1px solid var(--border-primary);
            box-shadow: 0 2px 8px var(--shadow-secondary);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--text-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin-bottom: 1rem;
            max-width: 600px;
        }

        .upload-form {
            background: var(--bg-secondary);
            border: 1px solid var(--border-primary);
            border-radius: 16px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 32px var(--shadow-primary);
            backdrop-filter: blur(10px);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .file-input-wrapper {
            position: relative;
            display: block;
            width: 100%;
            min-height: 120px;
            border: 2px dashed var(--border-primary);
            border-radius: 12px;
            background: var(--bg-tertiary);
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .file-input-wrapper:hover {
            border-color: var(--accent-primary);
            background: var(--bg-quaternary);
            box-shadow: 0 4px 16px var(--shadow-secondary);
        }

        .file-input-wrapper.dragover {
            border-color: var(--accent-primary);
            background: var(--bg-quaternary);
            box-shadow: 0 0 0 4px rgba(35, 134, 54, 0.1);
        }

        .file-input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 1rem;
            text-align: center;
        }

        .file-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            opacity: 0.7;
            display: flex;
            justify-content: center;
            align-items: center;
			pointer-events: none;
        }

        .file-icon img {
            width: 2.5rem;
            height: 2.5rem;
            object-fit: contain;
			filter: invert(1);
			pointer-events: none;
        }

        .file-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .file-text strong {
            color: var(--text-primary);
        }

        .input-field {
            width: 100%;
            padding: 0.875rem 1rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-primary);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(35, 134, 54, 0.1);
            background: var(--bg-quaternary);
        }

        .input-field::placeholder {
            color: var(--text-tertiary);
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem 2rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            box-shadow: 0 8px 25px rgba(35, 134, 54, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .result-container {
            margin-top: 2rem;
            text-align: center;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--gradient-secondary);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            box-shadow: 0 8px 25px rgba(9, 105, 218, 0.3);
            text-decoration: none;
            color: white;
        }

        .error-message {
            background: var(--bg-tertiary);
            border: 1px solid var(--accent-danger);
            border-radius: 10px;
            padding: 1rem;
            color: var(--accent-danger);
            text-align: center;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .upload-form {
                padding: 1.5rem;
            }

            .version {
                position: static;
                margin-bottom: 2rem;
                width: fit-content;
            }
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* File selected state */
        .file-selected {
            border-color: var(--accent-primary);
            background: var(--bg-quaternary);
        }

        .file-selected .file-icon {
            color: var(--accent-primary);
        }

        .file-selected .file-text {
            color: var(--text-primary);
        }
    </style>
</head>

<body>
    <div class="container">
        <span class="version">v2.0 clean</span>

        <div class="header">
            <h1>Batch Obfuscator</h1>
            <p class="subtitle">Easy way to obfuscate Windows batch files</p>
        </div>

        <form class="upload-form" enctype="multipart/form-data" action="" method="POST">
            <div class="form-group">
                <label for="file">Select batch file</label>
                <div class="file-input-wrapper" id="fileWrapper">
                    <input type="file" name="batchfile" class="file-input" id="file" accept=".bat" required>
                    <div class="file-input-content">
                        <div class="file-icon"><img src="batch_ico.png" alt="Batch file icon"></div>
                        <div class="file-text">
                            <strong>Click to browse</strong> or drag and drop<br>
                            <small>Only .bat files (max: 1MB)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="passage">Obfuscation passes</label>
                <input type="number" 
                       min="1" 
                       max="20" 
                       name="passage" 
                       class="input-field" 
                       id="passage"
                       placeholder="Number of passes (Default: 1, Max: 20)" 
                       value="1">
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-text">Obfuscate file</span>
            </button>
        </form>

        <?php if (isset($_FILES['batchfile'])): ?>
            <div class="result-container">
                <?php if (is_batch_file_valid($_FILES['batchfile'])): ?>
                    <?php
                    $passage = (isset($_POST['passage']) && $_POST['passage'] > 0 && $_POST['passage'] <= 20) 
                               ? (int)$_POST['passage'] 
                               : 1;

                    sleep(1);

                    ensure_data_directory();
					/* clean files older than 24 hours */
                    clean_old_files('data', 86400);

                    try {
                        $obfuscated_content = batchfile_obfuscate($_FILES['batchfile']['tmp_name'], $passage);
                        file_put_contents('data/'.$_FILES['batchfile']['name'], $obfuscated_content);
                    } catch (RuntimeException $e) {
                        echo '<div class="error-message"><strong>Error:</strong> '.htmlspecialchars($e->getMessage()).'</div>';
                        exit;
                    }
                    ?>
                    <a class="download-btn" href="./data/<?php echo htmlspecialchars($_FILES['batchfile']['name']); ?>">
                        Download <strong><?php echo htmlspecialchars($_FILES['batchfile']['name']); ?></strong> (<?php echo $passage; ?>x pass)
                    </a>
                <?php else: ?>
                    <div class="error-message"><strong>Error:</strong> No file selected, file exceeds 1MB, or file is not a valid .bat file</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const fileInput = document.getElementById('file');
        const fileWrapper = document.getElementById('fileWrapper');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileWrapper.classList.add('file-selected');
                const content = fileWrapper.querySelector('.file-input-content');
                content.innerHTML = `
                    <div class="file-icon"><img src="batch_ico.png" alt="Batch file icon"></div>
                    <div class="file-text">
                        <strong>${file.name}</strong><br>
                        <small>${(file.size / 1024).toFixed(1)} KB</small>
                    </div>
                `;
            }
        });

        fileWrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileWrapper.classList.add('dragover');
        });

        fileWrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileWrapper.classList.remove('dragover');
        });

        fileWrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            fileWrapper.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });

        document.querySelector('.upload-form').addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.innerHTML = '<span class="loading"></span> Processing...';
        });
    </script>
</body>
</html>

<?php

function batchfile_obfuscate(string $batchfile, int $pass = 1): string {
    $script = file_get_contents($batchfile);
    if ($script === false) throw new RuntimeException("Failed to read batch file: {$batchfile}");
    $batchfile_obfuscate = '';
    
    for ($i = 0; $i < $pass; $i++) {
        /* for subsequent passes, use what has already been obfuscated */
        if ($i > 0) $script = $batchfile_obfuscate;
        /* clear all previous work for this pass */
        $batchfile_obfuscate = '';

        $stringVar0 = '@ 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringVar1 = '_ÄÅÇÉÑÖÜáàâäãåçéèêëíìîïñóòôöõúùûüabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringVar8 = 'abcdefghijklmnopqrstuvwxyz';
        $stringVar2 = '_¯-ஐ→あⓛⓞⓥⓔ｡°º¤εïз╬㊗⑪⑫⑬㊀㊁㊂のðabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		/* variable value for this pass */
        $stringGen1 = substr(str_shuffle($stringVar1), 0, rand(3, 5));
        $stringGen2 = '';

        $arrayTable = [];
        $arrayVar0 = str_split($stringVar0);
        shuffle($arrayVar0);
        
        foreach ($arrayVar0 as $pos => $char) {
            $arrayTable[] = [$char, '%'.$stringGen1.':~'.$pos.',1%'];
            $stringGen2 .= $char;
        }

        $arrayText = str_split($script);
        $convertWaitVar = false;
        $convertWaitLabel = false;
		/* track whether we're in % or ! variable */
        $varType = '';
		/* consider the first line as a line break in case there's a label on the first line */
        $sautLigne = true;
        
        if ($i === $pass - 1) $batchfile_obfuscate .= "\xFF\xFE".'&@cls&';
        $batchfile_obfuscate .= '@set "'.$stringGen1.'='.$stringGen2.'"'.PHP_EOL;

        foreach ($arrayText as &$charOriginal) {
            if ($sautLigne === true && $charOriginal === ':') {
				/* if we detect a label */
                $convertWaitLabel = true;
            } 

            if ($charOriginal === "\n") {
				/* remember that we're breaking a line for tests on the next line */
                $sautLigne = true; 
				/* reset to false since we can't be in a variable if we break a line */
                $convertWaitVar = false;
				/* reset label to false since we're moving to the next line */
                $convertWaitLabel = false; 
                $varType = '';
            } else {
                $sautLigne = false;
            }

            if ($charOriginal === ' ') {
				/* to resume after a : in a string since a label cannot contain spaces */
                $convertWaitLabel = false;
            }

            /* improved variable detection for consecutive variables like %0%random% */
            if ($convertWaitVar === false && ($charOriginal === '%' || $charOriginal === '!')) { 
				/* if we encounter the first % or ! of a variable to avoid corruption */
                $convertWaitVar = true;
				/* remember which type of variable delimiter we're using */
                $varType = $charOriginal;
            } elseif ($convertWaitVar === true && $charOriginal === $varType) { 
				/* if we encounter the matching end delimiter, close this variable */
                $convertWaitVar = false; 
				/* for cases like [%time:~0,-3%] to resume after the variable */
                $convertWaitLabel = false; 
                $varType = '';
                /* immediately check if this might be the start of another variable */
                /* this handles cases like %0%random% where % serves dual purpose */
                if ($charOriginal === '%' || $charOriginal === '!') {
                    $convertWaitVar = true;
                    $varType = $charOriginal;
                }
            }

            if ($convertWaitVar === false && $convertWaitLabel === false && $sautLigne === false) {
				/* if we're not in a variable or label, then replace */
                $convert = false;
                foreach ($arrayTable as [$char1, $char2]) {
                    if ($charOriginal === $char1) {
                        if (rand(1, 20) === 8) {
							/* replace if found in table + add empty variable (1 in 20 times) */
                            $batchfile_obfuscate .= $char2.'%'.substr(str_shuffle($stringVar1), 3, 7).'%';
                        } else {
                            $batchfile_obfuscate .= $char2;
                        }
                        $convert = true;
                    }
                }
                if ($convert === false) {
					/* if not found in table, don't replace */
                    $batchfile_obfuscate .= $charOriginal;
                }
            } else {
				/* we are in a variable or label so don't replace anything */
                $batchfile_obfuscate .= $charOriginal;
            }
        }
    }
    return html_entity_decode($batchfile_obfuscate);
}

function is_batch_file_valid(array $file): bool {
    return $file['error'] === 0 
        && $file['size'] <= 1000000 
        && strtolower(substr($file['name'], -4)) === '.bat';
}

function clean_old_files(string $directory, int $maxAge = 86400): void {
    if (!is_dir($directory)) return;
    foreach (glob($directory.'/*') as $file) {
        if (is_file($file) && filemtime($file) < time() - $maxAge) {
            unlink($file);
        }
    }
}

function ensure_data_directory(): void {
    if (!is_dir('data')) {
        mkdir('data', 0755, true);
    }
}

?>
