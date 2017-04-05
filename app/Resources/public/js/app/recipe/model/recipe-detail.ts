import {Ingredient} from './ingredient';
import {Photo} from './photo';
import {Cooking} from './cooking';
import {Recipe} from './recipe';
import {RecipeDetailResponseDto} from './dto/recipe-detail-response.dto';

export class RecipeDetail extends Recipe {
    photos?: Photo;
    ingredients: Ingredient[];
    cookings: Cooking[];

    constructor(dto: RecipeDetailResponseDto) {
        super(dto);

        this.photos = dto.photos;
        this.ingredients = dto.ingredients;
        this.cookings = dto.cookings;
    }
}
