import {Cooking} from './cooking';
import {RecipeDetailDto} from './dto/recipe-detail.dto';
import {Ingredient} from './ingredient';
import {Photo} from './photo';
import {Recipe} from './recipe';

export class RecipeDetail extends Recipe {
    public ingredients: Ingredient[];
    public cookings: Cooking[];
    public photos: Photo[];

    constructor(dto: RecipeDetailDto) {
        super(dto);

        this.ingredients = dto.ingredients.map((ingredientDto) => new Ingredient(ingredientDto));
        this.cookings = dto.cookings.map((cookingDto) => new Cooking(cookingDto));
        this.photos = dto.photos.map((photoDto) => new Photo(photoDto));
    }
}
