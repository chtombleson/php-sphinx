<?php
namespace Sphinx;

class SQLBuilder
{
    protected $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function buildSQL()
    {
        if (empty($this->query->getFields()) && empty($this->query->getIndexes())) {
            throw new Exception('Sphinx SQL Builder: no fields or indexes are set in the query');
        }

        $sql  = 'SELECT ' . implode(',', $this->query->getFields());
        $sql .= ' FROM ' . implode(',', $this->query->getIndexes());

        $parameters = [];
        $wheres = [];
        $matches = [];

        foreach ($this->query->getWhere() as $field => $value) {
            $fieldParts = explode(':', $field);

            if (count($fieldParts) == 2) {
                switch ($fieldParts[1]) {
                    case 'Equal':
                        $wheres[] = $fieldParts[0] . '=?';
                        $parameters[] = $value;
                        break;

                    case 'NotEqual':
                        $wheres[] = $fieldParts[0] . '!=?';
                        $parameters[] = $value;
                        break;

                    case 'LessThan':
                        $wheres[] = $fieldParts[0] . '<?';
                        $parameters[] = $value;
                        break;

                    case 'LessThanOrEqualTo':
                        $wheres[] = $fieldParts[0] . '<=?';
                        $parameters[] = $value;
                        break;

                    case 'GreaterThan':
                        $wheres[] = $fieldParts[0] . '>?';
                        $parameters[] = $value;
                        break;

                    case 'GreaterThanOrEqualTo':
                        $wheres[] = $fieldParts[0] . '>=?';
                        $parameters[] = $value;
                        break;

                    case 'In':
                        if (!is_array($value)) {
                            $value = [$value];
                        }

                        $wheres[] = $fieldParts[0] . ' IN(' . implode(',', array_pad([], count($value), '?')) . ')';
                        $parameters[] = $value;
                        break;

                    case 'Not':
                        $wheres[] = $fieldParts[0] . ' NOT ?';
                        $parameters[] = $value;
                        break;

                    case 'Between':
                        $wheres[] = $fieldParts[0] . ' BETWEEN ?  AND ?';
                        $parameters[] = $value;
                        break;

                    case 'Match':
                        $matches[$fieldParts[0]] = $value;
                        break;
                }
            } else {
                $wheres[] = $field . '=?';
                $parameters[] = $value;
            }
        }

        if (!empty($matches)) {
            $match = '\'';

            foreach ($matches as $field => $value) {
                if (is_array($value)) {
                    $match .= '@' . $field . ' ' . implode('|', $value) . ' ';
                } else {
                    $match .= '@' . $field . ' ' . $value . ' ';
                }
            }

            $match = trim($match) . '\'';

            $wheres[] = 'MATCH(?)';
            $parameters[] = $match;
        }

        $sql .= ' WHERE ' . implode(' AND ', $wheres);

        if (!empty($this->query->getGroupBy())) {
            $sql .= ' GROUP BY ' . implode(',', $this->query->getGroupBy());
        }

        if (!empty($this->query->getOrderBy())) {
            $sql .= ' ORDER BY ';

            foreach ($this->query->getOrderBy() as $field => $order) {
                $sql .= $field . ' ' . $order . ',';
            }

            $sql = rtrim($sql, ',');
        }

        if (!empty($this->query->getLimit())) {
            $sql .= ' LIMIT ' . (int) $this->query->getOffset() . ',' . (int) $this->query->getLimit();
        }

        return [
            'query' => $sql,
            'parameters' => $parameters,
        ];
    }
}
