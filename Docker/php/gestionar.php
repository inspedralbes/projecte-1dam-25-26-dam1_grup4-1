      
    .btn-save{
    background-color: #4f46e5;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.8rem;
    cursor: pointer;
    }

    .btn-save:hover{
    background-color: #4f46e5cc;
    }

    .missatge{
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    padding: 10px 16px;
    border-radius: 8px;
    margin: 0 30px 16px 30px;
    font-size: 0.88rem;
    }

    .empty{
    text-align: center;
    padding: 40px;
    color: #9ca3af;
    }

    .badge{
    display: inline-block;
    font-size: 0.72rem;
    font-weight: bold;
    padding: 2px 8px;
    border-radius: 12px;
    margin-top: 4px;
    }

    .badge-ALTA{color:red}
    .badge-MITJANA{color:goldenrod}
    .badge-BAIXA{color:green}
    .badge-OBERTA{color:red}
    .badge-EN_PROCES{color:goldenrod}
    .badge-TANCADA{color:}

      
      
      
      
      
      
      <!-- FORMULARI per guardar PRIORITAT + ESTAT -->
        <form method="POST"style="display:contents">
          <input type="hidden" name="id" value="<?= (int)$inc['ID_INCIDENCIA'] ?>">
 
            <td>
           
            <div class="form-grup">
              <label>Prioritat</label>
              <select name="prioritat" onchange="updateBadge(this,'prioritat')">
                <?php foreach (['ALTA','MITJANA','BAIXA'] as $p): ?>
                  <option value="<?= $p ?>" <?= $inc['PRIORITAT'] === $p ? 'selected' : '' ?>>
                    <?= $p ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="badge badge-<?= htmlspecialchars($inc['PRIORITAT'] ?? 'BAIXA') ?>">
                <?= htmlspecialchars($inc['PRIORITAT'] ?? '—') ?>
              </span>
            </div>
          </td>
 
         
          <td>
            <div class="form-grup">
              <label>Estat</label>
              <select name="estat">
                <?php foreach (['OBERTA','EN_PROCES','TANCADA'] as $e): ?>
                  <option value="<?= $e ?>" <?= $inc['ESTAT'] === $e ? 'selected' : '' ?>>
                    <?= str_replace('_', ' ', $e) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="badge badge-<?= htmlspecialchars($inc['ESTAT'] ?? 'OBERTA') ?>">
                <?= str_replace('_', ' ', htmlspecialchars($inc['ESTAT'] ?? '—')) ?>
              </span>
            </div>
          </td>
 
          
          <td class="accions">
            <button type="submit" class="btn-save">▶ Guardar</button>
          </td>
 
        </form>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>