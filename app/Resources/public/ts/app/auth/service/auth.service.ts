import {Injectable} from "@angular/core";
import {Jwt} from "../model/jwt";

@Injectable()
export class AuthService {
    private jwt: Jwt;

    setJwt(jwt: Jwt): void {
        this.jwt = jwt;
    }

    getAuthorizationHeader(): string|null {
        if (!this.jwt) {
            return null;
        }

        return `Bearer {${this.jwt.token}}`;
    }
}