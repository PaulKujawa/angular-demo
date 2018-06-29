import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {RoutingService} from 'app/core/service/routing.service';
import {Observable} from 'rxjs';

export interface Credentials {
    username: string;
    password: string;
}

@Injectable({
    providedIn: CoreModule,
})
export class AuthRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService) {
    }

    public authenticate(credentials: Credentials): Observable<undefined> {
        const url = this.routingService.generate('fos_user_security_check');
        const body = {
            _username: credentials.username,
            _password: credentials.password,
        };

        return this.http.post<undefined>(url, body);
    }
}
