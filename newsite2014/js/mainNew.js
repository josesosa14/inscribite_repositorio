$(document).ready(function() {
    
    // cuando se abre el acordion events
    $('#accordion-events .panel').on('show.bs.collapse', function () {
        var panel = $(this);
        var heading = panel.find('.panel-heading');
        var colActions = panel.find('.col-actions');
        var actionsHTML = colActions.html();
        var actions = panel.find('.panel-body').find('.actions');
        
        // oculta heading
        heading.hide();
        
        // setea clase open al panel
        panel.addClass('open');

        // inserta el html de colActions en la div actions
        actions.append(actionsHTML);
        
        // oculta todas las a en actions
        actions.find('a').hide();
        
        // muestra controles especiales
		actions.find('a.icon.control').show();
		actions.find('a.icon.tag').show();
		actions.find('a.icon.status-green').show();
		actions.find('a.icon.delete').show();
		actions.find('a.icon.status-red').show();
		actions.find('a.icon-go').show();
        
        colActions.html('');
    });

    // cuando se cierra el acordion events
    $('#accordion-events .panel').on('hide.bs.collapse', function () {
        var panel = $(this);
        var heading = panel.find('.panel-heading');
        var colActions = panel.find('.col-actions');
        var actionsHTML = panel.find('.panel-body').find('.actions').html();

        heading.show();
        
        // inserta el html de colActions en la div colActions
        colActions.html(actionsHTML);
        
        // quita clase open al panel
        panel.removeClass('open');
        
        // limpia la div actions
        panel.find('.panel-body').find('.actions').html(null);
        
        // muestra controles especiales
        colActions.find('a').show();
        colActions.find('a.status-green').hide();
        colActions.find('a.status-red').hide();
    });
    
    // cuando se abre el acordion vacantes
    $('#accordion-vacantes .panel').on('show.bs.collapse', function () {
        $(this).addClass('open');
    });
    
    // cuando se cierra el acordion vacantes
    $('#accordion-vacantes .panel').on('hide.bs.collapse', function () {   
        $(this).removeClass('open');
    });
    
});