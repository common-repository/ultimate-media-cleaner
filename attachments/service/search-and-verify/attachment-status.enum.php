<?php

abstract class UMC_AttachmentStatus {
    
    const UNKNOWN = 'UNKNOWN';
    const USED = 'USED';
    const NOT_USED = 'NOT_USED';

    const ASKING = 'ASKING';
    const ERROR = 'ERROR';

    const ERASING = 'ERASING';
    const DELETED = 'DELETED';

    const IN_DATABASE = 'IN_DATABASE';
    const IN_SERVER = 'IN_SERVER';

    const MAKING_BACKUP = 'MAKING_BACKUP';
    const BACKUP_MADE = 'BACKUP_MADE';
    const ERROR_BACKUP = 'ERROR_BACKUP';

    const ERROR_DELETE = 'ERROR_DELETE';
}
