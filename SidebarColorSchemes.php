<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sidebar Color Schemes - Birth & Death Registration</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/sidebar-color-schemes.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    
    <style>
        .color-scheme-selector {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin: 20px;
        }
        
        .scheme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .scheme-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .scheme-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .scheme-preview {
            width: 100%;
            height: 60px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .scheme-corporate-dark { background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); }
        .scheme-blue-purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .scheme-teal-blue { background: linear-gradient(135deg, #1CB5E0 0%, #000851 100%); }
        .scheme-green-blue { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); }
        .scheme-purple-pink { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .scheme-orange-red { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #333; }
        .scheme-dark-modern { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); }
        .scheme-corporate { background: linear-gradient(135deg, #3742fa 0%, #2f3542 100%); }
        .scheme-mint { background: linear-gradient(135deg, #2ed573 0%, #1e3799 100%); }
        .scheme-sunset { background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%); }
        .scheme-royal { background: linear-gradient(135deg, #8e44ad 0%, #3742fa 100%); }
        .scheme-ocean { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); }
        
        .current-scheme {
            border: 3px solid #4CAF50;
        }
        
        .instructions {
            background: #f8f9fa;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin: 30px 0;
            border-radius: 5px;
        }
        
        .btn-apply {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        
        .btn-apply:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel" style="margin-left: 0; width: 100%;">
                <div class="content-wrapper">
                    <div class="color-scheme-selector">
                        <h2 class="text-center mb-4">📊 Sidebar Color Schemes</h2>
                        <p class="text-center text-muted">Choose a color scheme for your sidebar navigation</p>
                        
                        <div class="instructions">
                            <h5>🛠️ How to Apply a Color Scheme:</h5>
                            <ol>
                                <li>Click on any color scheme below to preview it</li>
                                <li>Copy the provided CSS code to your <code>sidebar.php</code> file</li>
                                <li>Replace the current background style in the sidebar element</li>
                                <li>Save and refresh your application to see the changes</li>
                            </ol>
                        </div>
                        
                        <div class="scheme-grid">
                            <div class="scheme-card current-scheme" onclick="selectScheme('corporate-dark')">
                                <div class="scheme-preview scheme-corporate-dark">Current Active</div>
                                <h6>Corporate Dark Blue</h6>
                                <p class="text-muted">Professional and clean</p>
                                <button class="btn-apply">Current Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('blue-purple')">
                                <div class="scheme-preview scheme-blue-purple">Blue-Purple</div>
                                <h6>Blue-Purple Gradient</h6>
                                <p class="text-muted">Modern and professional</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                                <div class="scheme-preview scheme-teal-blue">Teal-Blue</div>
                                <h6>Teal-Blue Gradient</h6>
                                <p class="text-muted">Cool and refreshing</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('green-blue')">
                                <div class="scheme-preview scheme-green-blue">Green-Blue</div>
                                <h6>Green-Blue Gradient</h6>
                                <p class="text-muted">Calm and trustworthy</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('purple-pink')">
                                <div class="scheme-preview scheme-purple-pink">Purple-Pink</div>
                                <h6>Purple-Pink Gradient</h6>
                                <p class="text-muted">Soft and elegant</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('orange-red')">
                                <div class="scheme-preview scheme-orange-red">Orange-Red</div>
                                <h6>Orange-Red Gradient</h6>
                                <p class="text-muted">Warm and energetic</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('dark-modern')">
                                <div class="scheme-preview scheme-dark-modern">Dark Modern</div>
                                <h6>Dark Modern</h6>
                                <p class="text-muted">Sleek and sophisticated</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('corporate')">
                                <div class="scheme-preview scheme-corporate">Corporate Blue</div>
                                <h6>Corporate Blue</h6>
                                <p class="text-muted">Business professional</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('mint')">
                                <div class="scheme-preview scheme-mint">Mint Green</div>
                                <h6>Mint Green</h6>
                                <p class="text-muted">Fresh and vibrant</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('sunset')">
                                <div class="scheme-preview scheme-sunset">Sunset Orange</div>
                                <h6>Sunset Orange</h6>
                                <p class="text-muted">Warm and inviting</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('royal')">
                                <div class="scheme-preview scheme-royal">Royal Purple</div>
                                <h6>Royal Purple</h6>
                                <p class="text-muted">Luxurious and bold</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                            
                            <div class="scheme-card" onclick="selectScheme('ocean')">
                                <div class="scheme-preview scheme-ocean">Ocean Blue</div>
                                <h6>Ocean Blue</h6>
                                <p class="text-muted">Deep and calming</p>
                                <button class="btn-apply">Apply Scheme</button>
                            </div>
                        </div>
                        
                        <div id="cssCode" class="mt-4" style="display: none;">
                            <h5>📋 CSS Code to Apply:</h5>
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; font-family: monospace; font-size: 14px; border: 1px solid #dee2e6;">
                                <div id="cssCodeContent"></div>
                            </div>
                            <p class="mt-3 text-muted">
                                <strong>Instructions:</strong> Replace the <code>background</code> style in your sidebar element with the code above.
                            </p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="AdminDashboard.php" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const schemes = {
            'corporate-dark': 'linear-gradient(180deg, #1e293b 0%, #0f172a 100%)',
            'blue-purple': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'teal-blue': 'linear-gradient(135deg, #1CB5E0 0%, #000851 100%)',
            'green-blue': 'linear-gradient(135deg, #74b9ff 0%, #0984e3 100%)',
            'purple-pink': 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
            'orange-red': 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'dark-modern': 'linear-gradient(135deg, #2c3e50 0%, #34495e 100%)',
            'corporate': 'linear-gradient(135deg, #3742fa 0%, #2f3542 100%)',
            'mint': 'linear-gradient(135deg, #2ed573 0%, #1e3799 100%)',
            'sunset': 'linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%)',
            'royal': 'linear-gradient(135deg, #8e44ad 0%, #3742fa 100%)',
            'ocean': 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)'
        };
        
        function selectScheme(schemeName) {
            // Remove current-scheme class from all cards
            document.querySelectorAll('.scheme-card').forEach(card => {
                card.classList.remove('current-scheme');
            });
            
            // Add current-scheme class to selected card
            event.currentTarget.classList.add('current-scheme');
            
            // Show CSS code
            const cssCode = document.getElementById('cssCode');
            const cssContent = document.getElementById('cssCodeContent');
            
            cssContent.innerHTML = `background: ${schemes[schemeName]};`;
            cssCode.style.display = 'block';
            
            // Update button text
            document.querySelectorAll('.btn-apply').forEach(btn => {
                btn.textContent = 'Apply Scheme';
            });
            event.currentTarget.querySelector('.btn-apply').textContent = 'Selected Scheme';
        }
    </script>
</body>
</html>