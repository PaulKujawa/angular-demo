import {RecipeResponseDto} from './recipe-list-response.dto';
import {IngredientDto} from './ingredient.dto';
import {CookingDto} from './cooking.dto';
import {PhotoDto} from './photo.dto';

export interface RecipeDetailResponseDto extends RecipeResponseDto {
    photos: PhotoDto[];
    ingredients: IngredientDto[];
    cookings: CookingDto[];
}
