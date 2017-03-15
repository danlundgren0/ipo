<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['columns']['control_points']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_controlpoint.uid = '. $respTechGroupId .' ORDER BY fe_users.username';