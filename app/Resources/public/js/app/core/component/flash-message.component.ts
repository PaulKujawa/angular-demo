import {Component} from '@angular/core';
import {FlashMessage} from '../model/flash-message';
import {FlashMessageService} from '../service/flash-message.service';

@Component({
    selector: 'flash-messages',
    template: `
        <div class="alert alert-dismissible alert-{{alert.type}}"
             role="alert"
             *ngFor="let alert of alerts; let i=index">
            {{alert.message}}
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                    (click)="onClick(i)">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    `,
})
export class FlashMessageComponent {
    public alerts: FlashMessage[];

    constructor(flashMessageService: FlashMessageService) {
        this.alerts = flashMessageService.getAll();
    }

    public onClick(index: number): void {
        this.alerts.splice(index, 1);
    }
}
