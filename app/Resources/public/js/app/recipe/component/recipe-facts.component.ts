import {Component, Input} from '@angular/core';
import {Recipe} from '../model/recipe';

@Component({
    selector: 'app-recipe-facts',
    template: `
        <div class="app-recipe-facts"
             [ngClass]="cssModifier.join(' ')">
            <span>
                <i *ngIf="recipe.isVegan"
                   class="material-icons">
                    local_florist
                </i>
            </span>

            <span>
                <i class="material-icons">bubble_chart</i>
                <span>{{ recipe.servings }}</span>
            </span>

            <div *ngIf="recipe.hasTime()">
                <i class="material-icons">schedule</i>
                <span>{{ getTime(recipe) }}</span>
            </div>
        </div>
    `,
})
export class RecipeFactsComponent {
    @Input() public recipe: Recipe;
    @Input() public cssModifier: string[] = [''];

    public getTime(recipe: Recipe): string {
        if (recipe.preparationTime && recipe.cookTime) {
            return `${recipe.preparationTime} / ${recipe.preparationTime + recipe.cookTime}`;
        }

        return String(recipe.preparationTime || recipe.cookTime);
    }
}
