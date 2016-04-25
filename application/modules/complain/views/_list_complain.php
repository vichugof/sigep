
<li >
    <div class="list-group">
        <?php foreach ($quejas as $queja): ?>
            <a href="#" class="list-group-item list-complain-sigep" data-frips="<?php echo $queja->frips; ?>">
                <h4 class="list-group-item-heading"><?php echo $queja->solicitante; ?></h4>
                <h4 class="list-group-item-heading"><?php echo $queja->solicitante_email. ' Radicado: '.$queja->radicado; ?></h4>
                <p class="list-group-item-text"> <?php echo word_limiter($queja->comentario, 10); ?> </p>
                <p class="list-group-item-text"> <?php echo $queja->fecha; ?> </p>
            </a>
        <?php endforeach; ?>
    </div>
</li>
