import './rxjs';

import {platformBrowser} from "@angular/platform-browser";
//noinspection TypeScriptCheckImport
import {AppModuleNgFactory} from "./app.module.ngfactory";

platformBrowser().bootstrapModuleFactory(AppModuleNgFactory);
