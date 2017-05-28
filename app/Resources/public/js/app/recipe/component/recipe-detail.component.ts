import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {FlashMessage} from '../../core/model/flash-message';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {Ingredient} from '../model/ingredient';
import {RecipeDetail} from '../model/recipe-detail';
import {RecipeRepository} from '../repository/recipe.repository';

@Component({
    template: `
        <h1 class="text-center">{{recipe?.name}}</h1>

        <div class="row">
            <div class="col-xs-12 col-md-6">
                <img class="img-circle center-block img-responsive" [src]="getImageUrl()">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-5">
                <h2>{{'app.recipe.ingredients'|trans}}*</h2>
                <table class="table">
                    <tbody>
                        <tr *ngFor="let ingredient of recipe?.ingredients">
                            <th scope="row">{{getMeasurement(ingredient)}}</th>
                            <td>{{ingredient.product.name}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">*{{'app.recipe.ingredient_sorting'|trans}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-1">
                <h2>{{'app.recipe.cooking'|trans}}</h2>
                <ul class="list-group">
                    <li class="list-group-item app-recipe__cooking" *ngFor="let cooking of recipe?.cookings">
                        {{cooking.description}}
                    </li>
                </ul>
            </div>
        </div>
    `,
})
export class RecipeDetailComponent implements OnInit {
    public recipe: RecipeDetail;
    private readonly idQuery = 'id';

    constructor(private recipeRepository: RecipeRepository,
                private activatedRoute: ActivatedRoute,
                private flashMsgService: FlashMessageService) {
    }

    public ngOnInit(): void {
        this.activatedRoute.params
            .switchMap((params: Params) => this.recipeRepository.getRecipe(+params[this.idQuery]))
            .subscribe(
                (recipe: RecipeDetail) => {
                    recipe.ingredients.sort((a, b) => b.kcal - a.kcal);
                    this.recipe = recipe;
                },
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error)),
            );
    }

    public getMeasurement(ingredient: Ingredient): string {
        return ingredient.amount && ingredient.measurement
            ? [ingredient.amount, ingredient.measurement.name].join(' ')
            : '';
    }

    public getImageUrl(): string {
        return this.recipe && this.recipe.thumbnail
            ? this.recipe.thumbnail.path
            : 'http://placehold.it/400x400';
    }
}
