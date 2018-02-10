import {IngredientDto} from './ingredient.dto';
import {InstructionDto} from './instruction.dto';
import {PhotoDto} from './photo.dto';
import {RecipeResponseDto} from './recipe-response.dto';

export interface RecipeDetailDto extends RecipeResponseDto {
    photos: PhotoDto[];
    ingredients: IngredientDto[];
    instructions: InstructionDto[];
    description: string;
}
