import {Injectable} from "@angular/core";
import {FlashMessage} from "../model/flash-message";

@Injectable()
export class FlashMessageService {
    private alerts: FlashMessage[] = [];

    getAll(): FlashMessage[] {
        return this.alerts;
    }

    push(flashMessage: FlashMessage): void {
        this.alerts.push(flashMessage);
    }
}
