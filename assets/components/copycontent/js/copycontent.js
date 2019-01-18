// Add our button to modAB toolbar
Ext.ComponentMgr.onAvailable('modx-action-buttons', function (modAB) {
    modAB.on('beforerender', function (modAB) {
        var index = 0
            ,saveBtn = modAB.getComponent('modx-abtn-save')
        ;
        if (saveBtn) {
            // Let's add the button after the save button
            index = modAB.items.indexOf(saveBtn) + 1;
        }
        modAB.insert(index, {
            xtype: 'button'
            ,text: _('copycontent.button')
            ,handler: function (btn, vent) {
                this.copyWindow = this.copyWindow || new CopyContent.Window({
                    record: MODx.request.id
                });
                this.copyWindow.show(vent.target);
            }
        });
    });
});

Ext.ns('CopyContent');
CopyContent.config = CopyContent.config || {};

// modal to offer content copy
CopyContent.Window = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('copycontent.title')
        ,url: CopyContent.config.connector
        ,saveBtnText: _('copycontent.copy_button')
        ,action: 'copycontent'
        ,fields: [{
            xtype: 'box'
            ,html: _('copycontent.description')
            ,style: 'margin-top: 15px; margin-bottom: 0;'
        },{
            xtype: 'box'
            ,html: _('copycontent.unsaved_warning')
            ,cls: 'panel-desc'
            ,style: 'margin-top: 15px; margin-bottom: 0;'
            ,hidden: true
            ,itemId: 'unsaved_warning'
        },{
            xtype: 'hidden'
            ,name: 'source_resource_id'
            ,value: config.record
            ,anchor: '100%'
        },{
            xtype: 'copycontent-combo-resource'
            ,name: 'target_resource_id'
            ,hiddenName: 'target_resource_id'
            ,anchor: '100%'
            ,fieldLabel: _('copycontent.target_label')
        },{
            xtype: 'xcheckbox'
            ,hideLabel: true
            ,boxLabel: _('copycontent.copy_tvs')
            ,name: 'copy_tvs'
        }]
    });
    CopyContent.Window.superclass.constructor.call(this, config);
    this.on('success', this.showSuccess);
    this.on('beforeshow', this.checkPendingChanges);
};
Ext.extend(CopyContent.Window, MODx.Window, {
    /**
     * Display a confirmation panel offering user to edit the target resource
     */
    showSuccess: function () {
        var values = this.fp.getForm().getValues();
        Ext.Msg.confirm(
            _('copycontent.success_title')
            ,_('copycontent.success_message', {
                target: values['target_resource_id'] || ''
            })
            ,function (btnText) {
                if (btnText === 'yes') {
                    MODx.loadPage('resource/update', 'id=' + values['target_resource_id']);
                }
            }
        );
    }
    /**
     * Add a listener to resource panel (if possible) to check for field changes
     *
     * @param {CopyContent.Window} window
     */
    ,checkPendingChanges: function (window) {
        var panel = Ext.getCmp('modx-panel-resource');
        if (!panel) {
            return;
        }
        panel.addListener('fieldChange', function () {
            this.handleWarning(panel);
        }, window);

        window.handleWarning(panel);
    }
    /**
     * Display the warning message if pending changes are to be found on given panel
     *
     * @param {MODx.panel.Resource} panel
     */
    ,handleWarning: function (panel) {
        var warning = this.fp.getComponent('unsaved_warning');
        if (!warning) {
            return;
        }
        warning.hide();
        if (panel.warnUnsavedChanges) {
            warning.show();
        }
        // Handle window body size in case we added some content
        var fpHeight = this.fp.getEl().getHeight();
        this.body.setHeight(fpHeight + 15);
    }
});
Ext.reg('copycontent-copy-content', CopyContent.Window);

// combo box to select/search target/destination resource
CopyContent.Resource = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        displayField: 'pagetitle'
        ,valueField: 'id'
        ,mode: 'remote'
        ,fields: ['id', 'pagetitle', 'context_key']
        ,tpl: `<tpl for="."><div class="x-combo-list-item">{pagetitle} ({id} - {context_key})</div></tpl>`
        ,forceSelection: true
        ,editable: true
        ,enableKeyEvents: true
        ,pageSize: 20
        ,url: CopyContent.config.connector
        ,baseParams: {
            action: 'searchResource'
            ,current: MODx.request.id
        }
    });
    CopyContent.Resource.superclass.constructor.call(this, config);
};
Ext.extend(CopyContent.Resource, MODx.combo.ComboBox, {});
Ext.reg('copycontent-combo-resource', CopyContent.Resource);
