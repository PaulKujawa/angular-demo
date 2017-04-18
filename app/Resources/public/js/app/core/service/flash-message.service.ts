import {Injectable} from '@angular/core';
import {FlashMessage} from '../model/flash-message';

@Injectable()
export class FlashMessageService {
    private alerts: FlashMessage[] = [];

    public getAll(): FlashMessage[] {
        return this.alerts;
    }

    public push(flashMessage: FlashMessage): void {
        this.alerts.push(flashMessage);
    }
}
