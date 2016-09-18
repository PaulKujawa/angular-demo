import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Http} from "@angular/http";
import {Recipe} from "../model/recipe";
import {RoutingService} from "../../core/service/routing.service";

@Injectable()
export class RecipeRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {}

    getRecipes(): Observable<Recipe[]> {
        const url = this.routingService.generate('api_get_recipes');

        return this.http.get(url)
            .map(recipes => recipes.json() || {} )
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    getRecipe(id: number): Observable<Recipe> {
        const url = this.routingService.generate('api_get_recipe', {'id': id});

        return this.http.get(url)
            .map(recipe => recipe.json() || {} )
            .catch(error => Observable.throw(error.message || error.statusText));
    }
}
