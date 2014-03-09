<div id="footer">
    <div class="container">
        <p><a href="<?php echo base_url(); ?>profile">Member Profiles</a>&middot;
                <a href="<?php echo base_url(); ?>competition/demos">Demo Schedule</a> &middot;
                <a href="<?php echo base_url(); ?>club">Links</a> &middot;
                <?php if(!empty($menu)) foreach($menu as $row): ?>
                    <a href="<?php echo base_url().'page/'.$row->slug.''; ?>"><?php echo $row->name; ?></a> 
                    <?php if ($row != end($menu)): ?>
                        &middot;
                    <?php endif; ?>
                <?php endforeach; ?>
                        &middot; <a href="mailto:admin@coloradodiscdogs.com?subject=Genral Inquiry">Contact Us</a>        
            <a href="#" class="pull-right">Back to top</a></p>
    </div>
</div>
