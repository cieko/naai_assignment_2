<?php if ($flash !== null): ?>
 <?php
        $flashIcon = '!';
        $flashMood = 'flash--angry';

 if ($flash['type'] === 'success') {
   $flashIcon = '✓';
   $flashMood = 'flash--happy';
 }
 ?>
   <div class="flash <?= $flashMood; ?>">
      <div class="flash__icon"><?= $flashIcon; ?></div>
        <div class="flash__copy">
            <p class="flash__title"><?= safeTxtOut($flash['title']); ?></p> <p class="flash__text"><?= safeTxtOut($flash['message']); ?></p>
        </div>
   </div>
<?php endif; ?>

