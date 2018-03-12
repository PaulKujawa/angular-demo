import {IngredientDto} from './ingredient.dto';
import {InstructionDto} from './instruction.dto';
import {RecipeDto} from './recipe.dto';

export interface RecipeDetailDto extends RecipeDto {
    ingredients: IngredientDto[];
    instructions: InstructionDto[];
    description: string;
}
