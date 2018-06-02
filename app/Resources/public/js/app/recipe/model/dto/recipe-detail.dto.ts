import {IngredientDto} from 'app/recipe/model/dto/ingredient.dto';
import {InstructionDto} from 'app/recipe/model/dto/instruction.dto';
import {RecipeDto} from 'app/recipe/model/dto/recipe.dto';

export interface RecipeDetailDto extends RecipeDto {
    ingredients: IngredientDto[];
    instructions: InstructionDto[];
    description: string;
}
