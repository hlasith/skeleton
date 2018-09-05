<?php if ($this->editmode): ?>
    <div>
        <div>
            <?= $this->wysiwyg('general_text'); ?>
        </div>
        <div>
            <div class="ngl-form form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"/>
                    <i class="far fa-square"></i>
                    <i class="fas fa-check-square d-none"></i>
                    <span>Hier steht einer von den unteren beiden Texten.</span>
                </label>
            </div>
            <div>
                <?= $this->wysiwyg('optIn_text', ["enterMode" => 2]); ?>
            </div>
            <div>
                <?= $this->wysiwyg('optOut_text', ["enterMode" => 2]); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div>
        <div>
            <?= $this->wysiwyg('general_text'); ?>
        </div>
        <div class="ngl-form mb-3">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" id="optInOutInput" type="checkbox" onchange="ngl.cms.TrackingManager.toggleOptOut()"/>
                    <i class="far fa-square"></i>
                    <i class="fas fa-check-square d-none"></i>
                    <span id="optIn_text" style="display: none"><?= $this->wysiwyg('optIn_text', ["enterMode" => 2]); ?></span>
                    <span id="optOut_text" style="display: none"><?= $this->wysiwyg('optOut_text', ["enterMode" => 2]); ?></span>
                </label>
            </div>
        </div>
    </div>
    <script>
        var isAnalyticsOptInOutPage = true;
    </script>
<?php endif; ?>