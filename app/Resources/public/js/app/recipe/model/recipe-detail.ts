import {Ingredient} from './ingredient';
import {Photo} from './photo';
import {Cooking} from './cooking';
import {Recipe} from './recipe';
import {RecipeDetailResponseDto} from './dto/recipe-detail-response.dto';

export class RecipeDetail extends Recipe {
    public ingredients: Ingredient[];
    public cookings: Cooking[];
    public photos?: Photo;

    constructor(dto: RecipeDetailResponseDto) {
        super(dto);

        this.ingredients = dto.ingredients;
        this.cookings = dto.cookings;
        this.photos = dto.photos;
    }
}
