import {TranslationService} from "../../../app/core/service/translation.service";

describe('TranslationService', () => {
    const demoTrans = 'foo';
    const demoChoice = 'bar';

    let service: TranslationService;

    beforeEach(() => {
        window.Translator = {
            trans: jasmine.createSpy('trans').and.returnValue(demoTrans),
            transChoice: jasmine.createSpy('transChoice').and.returnValue(demoChoice)
        };

        service = new TranslationService();
    });

    it('#trans should return translation', () => {
        expect(service.trans('app.demo.key')).toBe(demoTrans);
    });

    it('#trans should return translation', () => {
        expect(service.transChoice('app.demo.key', 1)).toBe(demoChoice);
    });
});
