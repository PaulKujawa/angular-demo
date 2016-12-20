import {Injectable} from "@angular/core";

@Injectable()
export class TranslationService {
    trans(id: string, parameters?: {}, domain?: string): string {
        return window.Translator.trans(id, parameters, domain);
    }

    transChoice(id: string, number: number, parameters?: {}, domain?: string): string {
        return window.Translator.transChoice(id, number, parameters, domain);
    }
}
