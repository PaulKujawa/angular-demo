import {FlashMessageService} from "../../../app/core/service/flash-message.service";
import {FlashMessage} from "../../../app/core/model/flash-message";

describe('FlashMessageService', () => {
    let service: FlashMessageService;

    beforeEach(() => {
        service = new FlashMessageService();
    });

    it('#push should store message to internal stack', () => {
        const flashMsg = new FlashMessage('info', 'message');
        service.push(flashMsg);
        expect(service.getAll()).toContain(flashMsg);
    });

    it('#getAll should return real value', () => {
        expect(service.getAll()).toEqual([]);
    });
});
