type FlashMessageType = 'danger'|'info'|'warning'|'success';

export class FlashMessage {
    constructor(public type: FlashMessageType,
                public message: string) {}
}
